<?php

namespace REBELinBLUE\Deployer\Presenters;

use Robbo\Presenter\Presenter;

/**
 * The view presenter for a server class.
 * @property string readable_runtime
 */
class ServerLogPresenter extends Presenter
{
    use RuntimePresenter;
}
