<?php

namespace App\DataTables\Academico;

use App\Criteria\Academico\AnotacoesAula\AnotacaoAulaCriteria;
use App\Models\Academico\AnotacaoAula;
use App\Repositories\Academico\AnotacaoAulaRepositoryEloquent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Exceptions\RepositoryException;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder as DataTablesBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AnotacaoAulaDataTable extends DataTable
{
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
            ->addColumn('turma', function (AnotacaoAula $anotacaoAula) {
                return $anotacaoAula->turma->nome;
            })
            ->addColumn('data', function (AnotacaoAula $anotacaoAula) {
                return Carbon::parse($anotacaoAula->data)->format('d/m/Y');
            })
            ->addColumn('hora', function (AnotacaoAula $anotacaoAula) {
                return Carbon::parse($anotacaoAula->hora)->format('H:m');
            })
            ->addColumn('action', 'dashboard.academico.anotacoes-aula.datatables.actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param AnotacaoAulaRepositoryEloquent $model
     * @return Builder
     * @throws RepositoryException
     */
    public function query(AnotacaoAulaRepositoryEloquent $model)
    {
        $model->pushCriteria(new AnotacaoAulaCriteria());

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
            Column::make('aluno'),
            Column::make('turma'),
            Column::make('descricao')->title('Descrição'),
            Column::make('data'),
            Column::make('hora'),
            Column::make('assinatura'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'anotacoes_aula_' . date('YmdHis');
    }
}
