<?php

namespace App\Transformers\Academico\Turmas;

use Google_Service_Classroom_Course;
use League\Fractal\TransformerAbstract;

/**
 * Class TurmaClassroomTransformer
 *
 * @package App\Transformers\Academico\Turmas
 */
class TurmaClassroomTransformer extends TransformerAbstract
{
    /**
     * @param Google_Service_Classroom_Course $turmaClassroom
     * @return string[]
     */
    public function transform(Google_Service_Classroom_Course $turmaClassroom)
    {
        return [
            'id' => $turmaClassroom->id,
            'nome' => $turmaClassroom->name,
            'sigla' => $turmaClassroom->section,
            'descricao_titulo' => $turmaClassroom->descriptionHeading,
            'descricao' => $turmaClassroom->description,
            'sala' => $turmaClassroom->room,
            'codigo_proprietario' => $turmaClassroom->ownerId,
            'codigo_acesso' => $turmaClassroom->enrollmentCode,
            'ativo' => $turmaClassroom->courseState,
            'link_sala' => $turmaClassroom->alternateLink,
        ];
    }
}