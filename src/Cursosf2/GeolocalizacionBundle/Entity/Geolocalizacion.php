<?php
/**
 * This file is part of Cursosf2Application.
 *
 * Cursosf2Application is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Foobar is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Cursosf2Application.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Cursosf2\GeolocalizacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Cursosf2_Geolocalizacion")
 */
class Geolocalizacion
{
    /**
     * @var
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var
     * @ORM\Column(type="float")
     */
    protected $lat;

    /**
     * @var
     * @ORM\Column(type="float")
     */
    protected $lng;

    /**
     * @var
     * @ORM\Column(type="string", length="255")
     */
    protected $city;

    /**
     * @var
     * @ORM\Column(type="string", length="255")
     */
    protected $state;

    public function getId() {
        return $this->id;
    }

    public function getLat() {
        return $this->lat;
    }
    public function setLat($lat) {
        $this->lat = $lat;
    }

    public function getLng() {
        return $this->lng;
    }
    public function setLng($lng) {
        $this->lng = $lng;
    }
    public function getCity() {
        return $this->city;
    }
    public function setCity($city) {
        $this->city = $city;
    }

    public function getState() {
        return $this->state;
    }
    public function setState($state) {
        $this->state = $state;
    }

    public function  __toString() {
        return $this->city.', '.$this->state;
    }
}
