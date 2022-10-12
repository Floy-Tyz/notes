<?php

namespace App\Infrastructure\AbstractClass\Sync;

use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


abstract class SyncAbstractCommand extends Command
{
    /**
     * @param EntityManagerInterface $entityManager
     * @param ParameterBagInterface $bag
     * @param Closure $newEntityCallback
     * @param string $entityClassName
     * @param string $configFileName
     */
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ParameterBagInterface $bag,
        private readonly Closure $newEntityCallback,
        private readonly string $entityClassName,
        private readonly string $configFileName,
    )
    {
        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $configEntities = require_once $this->bag->get('project_dir') . "/config/fixture/$this->configFileName";
        $databaseEntities = $this->entityManager->getRepository($this->entityClassName)->findAll();

        $configEntitiesKeys = array_map(fn(array $entity) => $entity['key'], $configEntities);
        $databaseEntitiesKeys = array_map(fn($entity) => $entity->getKey(), $databaseEntities);

        $newEntitiesKeys = array_diff($configEntitiesKeys, $databaseEntitiesKeys);

        $this->normalizeConfig($configEntities);

        foreach ($newEntitiesKeys as $newEntityKey){

            $method = $this->newEntityCallback;

            $entity = $method($configEntities[$newEntityKey]);

            $this->entityManager->persist($entity);
        }

        $this->entityManager->flush();

        $io->success('Request sync is successful, added items: '. implode(", ", $newEntitiesKeys));

        return Command::SUCCESS;
    }

    /**
     * @param array $configs
     * @return void
     */
    private function normalizeConfig(array &$configs): void
    {
        foreach ($configs as $config){
            $configs[$config['key']] = $config;
        }
    }

}