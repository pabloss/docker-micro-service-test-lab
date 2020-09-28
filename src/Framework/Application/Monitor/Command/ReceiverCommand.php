<?php
declare(strict_types=1);

namespace App\Framework\Application\Monitor\Command;

use App\Framework\Application\Monitor\Hub;
use App\Framework\Repository\RequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReceiverCommand extends Command
{
    protected static $defaultName = 'receiver';
    /**
     * @var Hub
     */
    private $hub;
    /**
     * @var RequestRepository
     */
    private $requestRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * WSServerCommand constructor.
     *
     * @param Hub                    $hub
     * @param RequestRepository      $requestRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(Hub $hub, RequestRepository $requestRepository, EntityManagerInterface $entityManager)
    {
        parent::__construct(self::$defaultName);
        $this->hub = $hub;
        $this->requestRepository = $requestRepository;
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            while (empty($all = $this->requestRepository->findAll())){}
            $ent = \end($all);
            $this->hub->receive($ent->getContent(), $ent->getHeader());
        } catch (\Exception $e) {
            die($e->getMessage() . "\n" . $e->getTraceAsString() ."\n");
        }
        $this->entityManager->remove($ent);
        $this->entityManager->flush();
    }
}
