<?php

/**
 * This class the main data handler.
 */

class Handler implements HandlerInterface
{
    private array $data = [];
    private array $arrayToWrite = [['driver_id', 'total_minutes_with_passenger']];

    /**
     * This method takes the data and converts it into an array with the following construction.
     * The key for internal array is - $timePickup.
     * If there are two passengers with the same $time Pickup, then the one with more is recorded - $timeDropOff.
     *
     * [
     *     "$idDriver" => [$timePickup => [$timePickup, $timeDropOff], $timePickup => [$timePickup, $timeDropOff]],
     *     "$idDriver" => [$timePickup => [$timePickup, $timeDropOff], $timePickup => [$timePickup, $timeDropOff]],
     * ]
     */
    public function set(int $idDriver, int $timePickup, int $timeDropOff): void
    {
        if (array_key_exists($idDriver, $this->data)) {
            if (array_key_exists($timePickup, $this->data[$idDriver])) {
                $oldTimeDropOff = $this->data[$idDriver][$timePickup]["timeDropOff"];
                if ($timeDropOff > $oldTimeDropOff) {
                    $this->data[$idDriver][$timePickup] = ["timePickup" => $timePickup, "timeDropOff" => $timeDropOff];
                }
            } else {
                $this->data[$idDriver][$timePickup] = ["timePickup" => $timePickup, "timeDropOff" => $timeDropOff];
            }
        } else {
            $this->data[$idDriver][$timePickup] = ["timePickup" => $timePickup, "timeDropOff" => $timeDropOff];
        }
    }

    /**
     * This method iterates over all the array data and sends it for processing, based on the received data,
     * it creates an array for writing to a file.
     * For a task, the total time is displayed in the format  - total_minutes:seconds !!!
     */
    public function run(): void
    {
        foreach ($this->data as $idDriver => $arr) {
            $time = $this->calculateTotalTime($arr);
            $strTime = intdiv($time,  60) .":" . gmdate("s", $time);
            $this->arrayToWrite[] = [$idDriver, $strTime];
        }
    }

    /**
     * First this method sorts the array by key, where the key is the start time of the passenger's trip.
     * Next this method then determines the unique total travel time!!!
     */
    private function calculateTotalTime(array $travelList): int
    {
        ksort($travelList);
        $totalTime = 0;
        $lastPeriodTime = ['timePickup' => 0, 'timeDropOff' => 0];

        foreach ($travelList as $arr) {
            if ($arr['timePickup'] >  $lastPeriodTime['timeDropOff']) {
                $totalTime = $totalTime + $lastPeriodTime['timeDropOff'] - $lastPeriodTime['timePickup'];
                $lastPeriodTime = ['timePickup' => $arr['timePickup'], 'timeDropOff' => $arr['timeDropOff']];
            } else {
                if ($arr['timeDropOff'] >= $lastPeriodTime['timeDropOff']) {
                    $lastPeriodTime = ['timePickup' => $lastPeriodTime['timePickup'], 'timeDropOff' => $arr['timeDropOff']];
                }
            }
        }
        return $totalTime + $lastPeriodTime['timeDropOff'] - $lastPeriodTime['timePickup'];
    }

    public function get(): array
    {
        return $this->arrayToWrite;
    }

}