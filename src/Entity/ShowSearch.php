<?php


namespace App\Entity;


class ShowSearch
{
private $date;

private $band;

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getBand()
    {
        return $this->band;
    }

    /**
     * @param mixed $band
     */
    public function setBand($band): void
    {
        $this->band = $band;
    }


}