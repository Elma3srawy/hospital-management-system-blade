<?php
namespace App\Repository;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Interfaces\SectionInterface;



class SectionRepository implements SectionInterface
{

    public function index()
    {
        $locale = app()->getLocale();

            $sections = DB::table("sections")
            ->leftJoin("section_translations",function($join) use($locale){
                $join->on("sections.id", "section_translations.section_id")
                    ->whereLocale($locale);
            })
            ->select("sections.id","description","section_translations.name", "locale" , 'created_at')
            ->get();

        return view("Dashboard.Sections.index", ["sections" => $sections]);
    }



    public function store($request)
    {
        try {
            DB::beginTransaction();
            $validated =  collect(['description'=>$request->description])
            ->put('created_at',Carbon::now());

            $id = DB::table("sections")->insertGetId($validated->all());

            $section_translation =
             collect([
                    'name'=>$request->name,
                    'section_id' => $id ,
                    'locale' => app()->getlocale()
                ]);


            DB::table("section_translations")->insert($section_translation->all());

            DB::commit();
            return to_route("section.index")->with('success',__("sections_trans.add_sections"));
        } catch (\Exception $e) {
            DB::rollback();
            return to_route("section.index")->with('error',$e->getMessage());
        }

    }


    public function show(string $id)
    {

    }



    public function update($request, string $id)
    {

        try {
            DB::beginTransaction();
            $validated = collect([
                    "description" => $request->validated('description'),
                    'updated_at' => Carbon::now()
                ]);

            DB::table("sections")
            ->whereId($request->id)
            ->update($validated->all());


            DB::table("section_translations")
            ->updateOrInsert(
                [
                    'section_id' => $request->id,
                    'locale' => app()->getLocale(),
                ],
                ['name' => $request->name]
            );

            DB::commit();
            return to_route("section.index")->with('success',__("sections_trans.edit_sections"));
        } catch (\Exception $e) {
            DB::rollback();
            return to_route("section.index")->with('error',$e->getMessage());
        }

    }


    public function destroy(string $id)
    {
        try {
            $id = collect(request()->validate(["id" => "exists:sections,id"]))->first();

            DB::table('sections')->whereId($id)->delete();
            return to_route("section.index")->with('success',__("sections_trans.delete_sections"));
        } catch (\Exception $e) {
            DB::rollback();
            return to_route("section.index")->with('error',$e->getMessage());
        }
    }


}








?>
