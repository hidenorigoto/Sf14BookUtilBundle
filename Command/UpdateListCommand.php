<?php

namespace Bundle\Sf14bookUtilBundle\Command;

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

        mb_internal_encoding('UTF-8');
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $finder = new Finder();
        $finder->files()->name('chap*.txt')->in(getcwd());
        foreach ($finder as $filePath)
        {
            $this->procOneFile($input, $output, $filePath);
        }
    }

    protected function procOneFile(InputInterface $input, OutputInterface $output, $filePath)
    {
        $output->writeln(sprintf('Processing... %s', basename($filePath)));
        preg_match('/chap0?(.+)\./', basename($filePath), $match);
        $num1 = $match[1];
        $num2 = 0;
        $num3 = 0;
        $listnum = 0;
        $tablenum = 0;
        $data = file($filePath);
        while(list($key, $value) = each($data))
        {
            if (preg_match('/■■■■(.+\d)(.*)/', $value, $match))
            {
                ++$num2;
                $num3 = 0;
                $value = sprintf("■■■■%s-%s%s\n", $num1, $num2, $match[2]);
                echo $value;
            }
            else if (preg_match('/■■■(.+\d)(.*)/', $value, $match))
            {
                ++$num3;
                $value = sprintf("■■■%s-%s-%s%s\n", $num1, $num2, $num3, $match[2]);
                echo $value;
            }
            else if (preg_match('/(☆|★)表([^¥s]+?[\dN]+)(.*)(☆|★)/', $value, $match))
            {
                ++$tablenum;
                $value = sprintf("★表%s-%s%s★\n", $num1, $tablenum, $match[3]);
                echo $value;
            }
            else if (preg_match('/(☆|★)［リスト([^］]+?[\dN]+)(.*)(☆|★)/', $value, $match))
            {
                ++$listnum;
                $value = sprintf("★［リスト%s-%s］%s★\n", $num1, $listnum, mb_substr($match[3], 1));
                echo $value;
            }
            $data[$key] = $value;
        }
        file_put_contents($filePath, implode('', $data));
    }
}

