<?php

namespace App\Infrastructure\Http\Services\Swagger;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

class NelmioExtension
{
    /**
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(private readonly ParameterBagInterface $parameterBag){}

    /**
     * @return array
     */
    public function __invoke(): array
    {
        $configurationFinder = Finder::create()
            ->in($this->parameterBag->get('project_dir') . '/src/Model/**/Resource/')
            ->depth(0)
            ->name(['nelmio_api_doc.yaml']);

        $components = [];

        foreach ($configurationFinder as $configurationFile)
        {
            $parsedConfigurationFile = Yaml::parseFile($configurationFile->getPathname());

            if ($this->checkComponentsExist($parsedConfigurationFile)){
                $components = array_merge_recursive($components, ['components' => $parsedConfigurationFile['nelmio_api_doc']['documentation']['components']]);
            }
        }

        return $components;
    }

    /**
     * @param array|null $parsedConfigurationFile
     * @return bool
     */
    private function checkComponentsExist(?array $parsedConfigurationFile): bool
    {
        return $parsedConfigurationFile
            && array_key_exists('nelmio_api_doc', $parsedConfigurationFile)
            && array_key_exists('documentation', $parsedConfigurationFile['nelmio_api_doc'])
            && array_key_exists('components', $parsedConfigurationFile['nelmio_api_doc']['documentation']);
    }
}