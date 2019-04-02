<?php

namespace App\Presenters;

use App\Transformers\BookTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BookPresenter.
 *
 * @package namespace App\Presenters;
 */
class BookPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BookTransformer();
    }
}
