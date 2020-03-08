<?php

namespace thread\app\widgets\nav;

/**
 * Class Search
 *
 * @package thread\app\widgets\nav
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 *
 * <?= Search::widget(); ?>
 *
 */
class Search extends \thread\bootstrap\Widget {

    public $view = 'Search';
    public $name = 'search';
    public $translationsBasePath = __DIR__ . '/messages';

}
