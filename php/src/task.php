<?php
class Task
{
    private int $id;
    private int $sinisterId;
    private string $title;
    private string $descriptionTask;
    private datetime $creation;
    private datetime $scheduled;
    private datetime $execution;
    private string $state;
}
