<?php

namespace App\Command;

use App\Notification\BddNotification;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class addBddMiniMaxCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:addBddMiniMaxiCommand';
    /**
     * @var BddNotification
     */
    private $bdd;

    public function __construct(string $name = null, BddNotification $bdd)
    {
        parent::__construct($name);
        $this->bdd = $bdd;
    }

    protected function configure()
    {
        $this->setName('app:addBddMiniMaxiCommand');
        $this->setDescription('Commande pour tache cron enregistrement en bdd');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->bdd->AddBddMiniMaxi();
        return 0;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;
    }

}