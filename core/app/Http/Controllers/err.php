// $url2 = 'https://api.envato.com/v3/market/author/sale?code='.$req->input('key');	        
            // $client = new GuzzleClient([
            //     'headers' => [                               
            //         'Authorization' => 'Bearer 027WLOqdvLXqdx1e5FEM8MDDNyly8NS8',
            //         'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:41.0) Gecko/20100101 Firefox/41.0',
            //         'timeout' => '20'
            //     ],
                
            // ]);  
    
            // $r = $client->request('GET', $url2);
            // $resp = json_decode($r->getBody()->getContents());  
    
            // if(isset($resp->item->id))
            // {
            	$act = activation_codes::where('code', $req->input('key'))->get();
                if( count($act) > 0 )
                {
                    if($act[0]->url == $req->input('url'))
                    {
                        return ['resp' => 'ok'];
                    }
                    else
                    {
                        return ['resp' => 'diff_domain'];
                    }
                }
                else
                {
                    $act = new activation_codes;
                    $act->status = 1;
                    $act->code = $req->input('key');
                    $act->url = $req->input('url');
                    $act->save();
                    
                    return ['resp' => 'ok'];
                }
                return ['resp' => 'err'];
            // }
            // else
            // {
            //     return ['resp' => 'not_found'];
            // }
            
            // return ['resp' => 'err']; 