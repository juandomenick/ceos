<?php

namespace App\DataTables\Academico;

use App\Criteria\Academico\Atividades\AtividadeCriteria;
use App\Models\Academico\Atividade;
use App\Repositories\Interfaces\Academico\Atividades\AtividadeRepository;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder as DataTablesBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

/**
 * Class AtividadesDataTable
 *
 * @package App\DataTables\Academico
 */
class AtividadesDataTable extends DataTable
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
            ->addColumn('disciplina', function (Atividade $atividade) {
                return $atividade->disciplina->nome;
            })
            ->addColumn('status', function (Atividade $atividade) {
                return $atividade->ativo ? 'Ativo' : 'Inativo';
            })
            ->addColumn('action', 'dashboard.academico.atividades.datatables.actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param AtividadeRepository $model
     * @return Builder
     */
    public function query(AtividadeRepository $model)
    {
        $model->pushCriteria(new AtividadeCriteria());

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
            Column::make('descricao')->title('Descrição'),
            Column::make('disciplina'),
            Column::make('tipo'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')
                ->title('Ações')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'atividades_' . date('YmdHis');
    }
}
