<?php

namespace App\Model\Note\Service\Manager;

use App\Model\Note\Http\Request\CreateApiNoteData;
use App\Model\Note\Http\Request\CreateApiPointData;
use App\Model\Note\Http\Request\UpdateApiNoteData;
use App\Model\Note\Orm\Entity\Note;
use App\Model\Note\Orm\Entity\Point;

interface NoteManagerInterface
{
    public function createNote(Note $note, CreateApiNoteData $data): void;

    public function updateNote(Note $note, UpdateApiNoteData $data): void;

    public function createPointByData(Note $note, CreateApiPointData $data): Point;
}