public function saveStory(Request $request)
    {	  
        if($file=$request->file('banner_image')){
            $name=time() . '-' . $file->getClientOriginalName();
            $file->move(public_path() . '/web_story/', $name);
            $banner_image=$name;
            //$file->move('web_story',$name);
        }
    	 $data=[
		    "title" => $request->input('title'),
		    "meta_keyword" => $request->input('meta_keyword'),
		    "meta_description" => $request->input('meta_description'),
		    "banner_image"=>$banner_image,
		    "created_at" =>date('Y-m-d'),
		];

		$sql1=DB::table('croma_web_story')->insertGetId($data);
        $images=array();
        if($files=$request->file('story_image')){
            foreach($files as $key => $file){
                $name=time() . '-' . $file->getClientOriginalName();
                $file->move(public_path() . '/web_story/', $name);
                //$file->move('web_story',$name);
                $images['story_image']=$name;
                $images['story_text']=$request->input('story_text')[$key];
                $images['story_id']=$sql1;
                $sql2=DB::table('croma_web_story_image')->insert($images);
            }
        }
        
        if($sql2){
            return back()->with('msg',"Story Saved Successfully");
        }else{
            return back()->with('msg',"Some Error");
        }

    } 







