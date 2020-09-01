<?php

namespace App\Command;


use App\Notification\twitterNotification;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class twitterCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:twitterCommand';

    /**
     * @var twitterNotification
     */
    private $twitter;

    public function __construct(string $name = null, twitterNotification $twitter)
    {
        parent::__construct($name);
        $this->twitter = $twitter;
    }

    protected function configure()
    {
        $this->setName('app:twitterCommand');
        $this->setDescription('Commande pour tache cron envoi twitter');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->twitter->Twitter();
        return 0;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;
    }

}