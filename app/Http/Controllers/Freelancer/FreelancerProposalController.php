<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use Illuminate\Http\Request;

class FreelancerProposalController extends Controller
{
    public function index()
    {
         $proposals = Bid::with('job')->where('freelancer_id', auth()->id())->paginate(10);

        return view('freelancer.proposals.index', compact('proposals'));
    }

    public function create()
    {
        // Assuming a job is passed or selected
        return view('freelancer.proposals.create');
    }

    public function store(Request $request)
    {
        // Logic to store proposal
        return redirect()->route('freelancer.proposals.index');
    }

     public function show(Bid $proposal)
     {
         $proposal->load('job');
         return view('freelancer.proposals.show', compact('proposal'));
     }
}
