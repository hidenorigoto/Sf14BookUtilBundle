<?php

namespace Bundle\Sf14bookBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;
use Symfony\Bundle\FrameworkBundle\Command\Command;
use Symfony\Component\Finder\Finder;

/**
 */
class UpdateListCommand extends Command
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
//            ->setDefinition(array(
//                new InputArgument('e', InputArgument::REQUIRED, 'The namespace of the bundle to create'),
//            ))
            ->setName('sf14book:update:list')
        ;
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $finder = new Finder();
        $finder->files()->name('chap*.txt')->in(getcwd());
        foreach ($finder as $file)
        {
            echo $file . PHP_EOL;
        }
    }
}

