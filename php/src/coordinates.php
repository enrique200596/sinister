<?php
class Coordinates
{
    private string $latitude;
    private string $longitude;
    private string $googleMapsUrl;

    public function __construct(string $latitude, string $longitude, string $googleMapsUrl)
    {
        $this->setLatitude($latitude);
        $this->setLongitude($longitude);
        $this->setGoogleMapsUrl($googleMapsUrl);
    }

    public function setLatitude(string $latitude): void
    {
        $this->latitude = $latitude;
    }

    public function getLatitude(): string
    {
        return $this->latitude;
    }

    public function setLongitude(string $longitude): void
    {
        $this->longitude = $longitude;
    }

    public function getLongitude(): string
    {
        return $this->longitude;
    }

    public function setGoogleMapsUrl(string $googleMapsUrl): void
    {
        $this->googleMapsUrl = $googleMapsUrl;
    }

    public function getGoogleMapsUrl(): string
    {
        return $this->googleMapsUrl;
    }
}
