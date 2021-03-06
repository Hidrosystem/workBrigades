<?php

namespace App\Http\Controllers;

use App\Colony;
use App\ColonyScope;
use App\Http\Requests;
use App\PersonalInformation;
use App\Sector;
use App\SettlementType;
use Illuminate\Http\Request;

class ColoniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colonies=Colony::SearchFromRequest()->PaginateForTable();
        return  view('admin.colonies.index',compact('colonies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
             $scopes=ColonyScope::lists('name','id');
            $settlements=SettlementType::lists('name', 'id');
            $sectors=Sector::lists('number','id');
            return view ('admin.colonies.create', compact('scopes','settlements','sectors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $colony=Colony::create($request->all());
        $colony->colonyScope()->associate(ColonyScope::find($request->colony_scope_id))->save();
        $colony->settlementType()->associate(SettlementType::find($request->settlement_type_id))->save();
        $colony->sector()->associate(Sector::find($request->sector))->save();
        return redirect()->route('colonies.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $colony=Colony::find($id);
        $scopes=ColonyScope::lists('name','id');
        $settlements=SettlementType::lists('name', 'id');
        $i=$colony->personalInformation()->count();
        
        return view('admin.colonies.show', compact('colony','scopes','settlements','i'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $colony=Colony::find($id);
        $scopes=ColonyScope::lists('name','id');
        $settlements=SettlementType::lists('name', 'id');
        $sectors=Sector::lists('number','id');
        return view('admin.colonies.edit', compact('colony','scopes','settlements','sectors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $colony=Colony::find($id);
        $colony->update($request->all());
        $colony->colonyScope()->associate(ColonyScope::find($request->colony_scope_id))->save();
        $colony->settlementType()->associate(SettlementType::find($request->settlement_type_id))->save();
        return redirect('colonies/' . $colony->id .'/edit');
        
    }
   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $colony=Colony::find($id);
        $colony->delete();

        return redirect('colonies');
    }
}
