<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServerExecuteCommandRequest;
use App\Http\Requests\ServerStoreRequest;
use App\Http\Requests\ServerUpdateRequest;
use App\Repositories\ServerRepository\Contracts\ServerRepositoryInterface;
use App\Services\ServerService\ServerService;
use App\Services\SSHService\SSHService;
use Inertia\Inertia;

class ServerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ServerRepositoryInterface $serverRepository)
    {
        return Inertia::render('Server/Index', [
            'servers' => $serverRepository->paginate(2),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Server/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServerStoreRequest $request, ServerRepositoryInterface $serverRepository)
    {
        $serverRepository->create(data: $request->safe()->only([
            'name',
            'host',
            'port',
            'username',
            'password',
        ]));

        return redirect()
            ->route('servers.index')
            ->withSuccess('Server added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, ServerRepositoryInterface $serverRepository)
    {
        return Inertia::render('Server/Edit', [
            'server' => $serverRepository->find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServerUpdateRequest $request, string $id, ServerRepositoryInterface $serverRepository)
    {
        $serverRepository->update(id: $id, data: $request->safe()->only([
            'name',
            'host',
            'port',
            'username',
            'password',
        ]));

        return redirect()
            ->route('servers.index')
            ->withSuccess('Server information updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, ServerRepositoryInterface $serverRepository)
    {
        $serverRepository->delete(id: $id);

        return redirect()
            ->route('servers.index')
            ->withSuccess('Server removed successfully!');
    }

    public function connect(string $id, ServerRepositoryInterface $serverRepository)
    {
        $server = $serverRepository->find($id);

        return Inertia::render('Server/Connect', [
            'server' => $server,
        ]);
    }

    public function executeCommand(ServerExecuteCommandRequest $request, string $id, ServerRepositoryInterface $serverRepository)
    {
        $server = $serverRepository->find($id);

        $ssh = new SSHService(host: $server->host, port: $server->port);

        if (!$ssh->login(username: $server->username, password: $server->password)) {
            return redirect()
                ->back()
                ->withError('SSH connection failed!');
        }

        $command = $request->command;

        $output = $ssh->execute(command: $command);

        return $this->successResponse(data: [
            'command' => $command,
            'output' => $output,
        ]);
    }
}
