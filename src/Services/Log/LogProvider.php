<?php


namespace App\Services\Log;


use App\Entity\Log;
use App\Repository\LogRepository;
use Doctrine\Common\Collections\ArrayCollection;

class LogProvider
{
    public function __construct(private LogRepository $logRepository)
    {
    }

    public function getLatestLogs(int $count = 3): ArrayCollection
    {
        $logs = new ArrayCollection();
        /** @var Log $log */
        foreach ($this->logRepository->findLatestLogs($count) as $log) {
            $logs->add($log);
        }
        return $logs;
    }
}