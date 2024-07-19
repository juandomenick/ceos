<?php

namespace App\DataTables\Academico;

use App\Models\Academico\Habilidade;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder as DataTablesBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

/**
 * Class HabilidadesDataTable
 *
 * @package App\DataTables\Academico
 */
class HabilidadesDataTable extends DataTable
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
            ->eloquent($query)
            ->addColumn('status', function (Habilidade $habilidade) {
                return $habilidade->ativo ? 'Ativa' : 'Inativa';
            })
            ->addColumn('action', 'dashboard.academico.habilidades.datatables.actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param Habilidade $model
     * @return Builder
     */
    public function query(Habilidade $model)
    {
        return $model->newQuery();
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
            Column::make('sigla'),
            Column::make('nivel')->title('Nível'),
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
        return 'habilidades_' . date('YmdHis');
    }
}
