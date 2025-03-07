<?php

namespace App\Http\Controllers;

use App\DTO\Counterparty\CounterpartyResponseDTO;
use App\DTO\Counterparty\CreateCounterpartyDTO;
use App\Models\Counterparty;
use App\Services\CounterpartyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Exception;

class CounterpartyController extends Controller
{
    public function __construct(private CounterpartyService $counterpartyService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->search;

        $counterparties = Counterparty::where('user_id', Auth::id())
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function($q) use ($searchTerm) {
                    $q->where('inn', 'like', '%' . $searchTerm . '%')
                        ->orWhere('name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('ogrn', 'like', '%' . $searchTerm . '%')
                        ->orWhere('address', 'like', '%' . $searchTerm . '%');
                });
            })
            ->paginate(5)
            ->withQueryString();

        return Inertia::render('Counterparty/Index', compact('counterparties', 'searchTerm'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Log::info('create counterparty');
        return Inertia::render('Counterparty/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCounterpartyDTO $data)
    {
        Log::info('store counterparty');
        if (!auth()->check()) {
            return redirect()->route('login')->withErrors(['error', 'Нужно войти в учетную запись']);
        }

        try {
            $this->counterpartyService->createCounterparty(auth()->user(), $data);
            return redirect()->route('counterparties.index')->with('success', 'Контрагент добавлен в базу');
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::error($message, [
                'error' => $e->getMessage(),
                'inn' => $data->inn,
            ]);

            return redirect()->route('counterparties.create')->with('error', $message);
        }
    }
}
