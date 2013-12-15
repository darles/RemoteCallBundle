<?php

namespace Darles\Bundle\RemoteCallBundle\DataCollector;

use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\HangmanBundle\Composer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

/**
 * Collects controller, template and entities data to show on toolbar
 *
 * @author Darius Leskauskas <dariusleskauskas@gmail.com>
 */
class RemoteCallDataCollector extends DataCollector {

    /**
     *
     */
    const REMOTE_CALL_URL = 'http://localhost:8091/?message=';

    /**
     *
     */
    const REMOTE_CALL_FILE_EXT = '.php';

    /**
     *
     */
    const REMOTE_CALL_BUNDLE_PARENT_DIR = '/src/';

    /**
     * @var \Doctrine\Common\Persistence\ManagerRegistry
     */
    private $registry;

    /**
     * @param ManagerRegistry $registry
     */
    function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * Collects data for the given Request and Response.
     *
     * @param Request $request A Request instance
     * @param Response $response A Response instance
     * @param \Exception $exception An Exception instance
     *
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data['controller'] = $request->attributes->get('_controller');
        $this->data['template'] = $request->attributes->get('_template', null);
        $this->data['entities'] = [];
        $this->generateEntitiesUrls();
    }

    /**
     * Get unique list of entities
     *
     * @return array
     */
    public function getUniqueEntitiesList()
    {
        $entitiesList = [];
        foreach ($this->registry->getManagers() as $em) {
            /** @var $factory \Doctrine\ORM\Mapping\ClassMetadataFactory */
            $factory = $em->getMetadataFactory();

            /** @var $class \Doctrine\ORM\Mapping\ClassMetadataInfo */
            foreach ($factory->getLoadedMetadata() as $class) {
                $entitiesList[] = $class->getName();
            }
        }

        return array_unique($entitiesList);
    }

    /**
     * Generate urls for entities list
     */
    public function generateEntitiesUrls()
    {
        foreach ($this->getUniqueEntitiesList() as $class) {
            $entity = self::REMOTE_CALL_BUNDLE_PARENT_DIR.str_replace('\\', '/', $class);
            $entityData = [
                'url' => self::REMOTE_CALL_URL.$entity.self::REMOTE_CALL_FILE_EXT.':1',
                'name' => $class,
            ];
            $this->data['entities'][] = $entityData;
        }
    }

    /**
     * @return mixed
     */
    public function getEntities()
    {
        return $this->data['entities'];
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        $controller = explode(':', $this->data['controller']);
        return array_shift($controller);
    }

    /**
     * @return string
     */
    public function getControllerUrl()
    {
        $controller = self::REMOTE_CALL_BUNDLE_PARENT_DIR.str_replace('\\', '/', $this->getController());
        return self::REMOTE_CALL_URL.$controller.self::REMOTE_CALL_FILE_EXT.':1';
    }

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->data['template'];
    }

    /**
     * @return string
     */
    public function getTemplateUrl()
    {
        if(!is_null($this->getTemplate())) {
            $templateUrl = self::REMOTE_CALL_BUNDLE_PARENT_DIR.str_replace('\\', '/', str_replace('@', '', $this->getTemplate()->getPath()));
            return self::REMOTE_CALL_URL.$templateUrl.':1';
        }

        return null;
    }

    /**
     * Returns the name of the collector.
     *
     * @return string The collector name
     *
     * @api
     */
    public function getName()
    {
        return 'remote';
    }

} 