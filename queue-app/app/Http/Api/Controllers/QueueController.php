<?php

namespace App\Http\Api\Controllers;

use App\Http\Requests\QueueRequest;
use App\Domain\Queue\Repositories\QueueRepository;
use App\Domain\Queue\Services\QueueDomainService;
use App\Http\Api\Presenters\QueuePresenter;
use App\Http\Controllers\Controller;

class QueueController extends Controller
{

    public function __construct(
        private QueueRepository $queueRepository,
        private QueueDomainService $queueDomainService
    )
    {
    }

    public function show(int $queueId)
    {
        $queue = $this->queueRepository->find($queueId);
        return response()->json(
            [
                'data' => new QueuePresenter($queue),
               'success' => true,
            ]
        );
    }

    public function create(QueueRequest $request)
    {
        $queue = $this->queueDomainService->create($request->toDTO());
        return response()->json(
            [
                'data' => new QueuePresenter($queue),
                'success' => true,
            ]);
    }

    public function update(QueueRequest $request, int $queueId)
    {
        $queue = $this->queueRepository->find($queueId);
        if (!$queue) {
            return response()->json(
                [
                   'success' => false,
                   'message' => 'Queue not found',
                ], 404
            );
        }

        $this->queueDomainService->update($queue, $request->toDTO());

        return response()->json(
            [
                'data' => new QueuePresenter($queue),
               'success' => true,
            ]
        );
    }

    public function delete(int $queueId)
    {
        $queue = $this->queueRepository->find($queueId);
        if (!$queue) {
            return response()->json(
                [
                   'success' => false,
                   'message' => 'Queue not found',
                ], 404
            );
        }

        $queue->delete();

        return response()->json(
            [
               'success' => true,
               'message' => 'Queue deleted successfully',
            ]
        );
    }
}
