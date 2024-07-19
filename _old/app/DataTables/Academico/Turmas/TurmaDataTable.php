<?php

namespace App\DataTables\Academico\Turmas;

use App\Models\Academico\Turmas\Turma;
use App\Repositories\Academico\Turmas\TurmaRepositoryEloquent;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Exceptions\RepositoryException;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder as DataTablesBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TurmaDataTable extends DataTable
{
    /**
     * Status de Turmas do Classroom
     */
    private const STATUS_CLASSROOM = [
        'ACTIVE' => 'Ativo',
        'ARCHIVED' => 'Arquivado',
        'PROVISIONED' => 'Provisionado',
        'DECLINED' => 'Recusado',
        'SUSPENDED' => 'Suspenso'
    ];

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->collection($query)
            ->addColumn('status', function($turma) {
               return $this->getStatus($turma);
            })
            ->addColumn('origem', function($turma) {
                return $turma instanceof Turma ? 'Céos' : 'Classroom';
            })
            ->addColumn('propriedade', function($turma) {
                return $this->getPropriedade($turma);
            })
            ->addColumn('action', function ($turma) {
                $turma = (object) $turma;

                return view('dashboard.academico.turmas.datatables.actions', compact('turma'));
            });
    }

    /**
     * Retorna status da turma.
     *
     * @param $turma
     * @return string
     */
    private function getStatus($turma): string
    {
        if ($turma instanceof Turma) {
            return $turma->ativo ? "Ativo" : "Inativo";
        } else {
            return self::STATUS_CLASSROOM[$turma['ativo']];
        }
    }

    /**
     * Retorna nível de propriedade do usuário autenticado sobre a turma (se é professor ou aluno).
     *
     * @param $turma
     * @return string
     */
    private function getPropriedade($turma): string
    {
        if ($turma instanceof Turma) {
            return usuarioPodeAlterarTurma($turma) ? 'Professor' : 'Aluno';
        } else {
            return $turma['codigo_proprietario'] == Auth::user()->google_id ? 'Professor' : 'Aluno';
        }
    }

    /**
     * Get query source of dataTable.
     *
     * @param TurmaRepositoryEloquent $model
     * @return Collection
     * @throws RepositoryException
     */
    public function query(TurmaRepositoryEloquent $model)
    {
        return $model->all();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return DataTablesBuilder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('nome')->title('Nome'),
            Column::computed('status')->title('Status'),
            Column::computed('codigo_acesso')->title('Código de Acesso'),
            Column::computed('origem')->title('Origem'),
            Column::computed('propriedade')->title('Propriedade'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'turmas' . date('YmdHis');
    }
}
