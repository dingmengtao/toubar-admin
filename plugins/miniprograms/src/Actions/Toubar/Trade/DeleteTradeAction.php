<?php namespace WebEd\Plugins\Miniprograms\Actions\Toubar\Trade;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Miniprograms\Repositories\Contracts\TradeRepositoryContract;
use WebEd\Plugins\Miniprograms\Repositories\TradeRepository;

class DeleteTradeAction extends AbstractAction
{
    /**
     * @var TradeRepository
     */
    protected $repository;

    public function __construct(TradeRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @param bool $force
     * @return array
     */
    public function run($id, $force = false)
    {
        $id = do_filter(BASE_FILTER_BEFORE_DELETE, $id, WEBED_TOUBAR_TRADE);

        $result = $this->repository->deleteTrade($id, $force);

        do_action(BASE_ACTION_AFTER_DELETE, WEBED_TOUBAR_TRADE, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
