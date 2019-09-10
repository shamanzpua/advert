<?php

namespace App\Services\LocationParser;

use App\Models\Location;

/**
 * Class Parser
 * @package App\Services\LocationParser
 * TODO: make it More (S)OLID
 */
class Parser
{
    public function run()
    {
        $rootLocations = json_decode(file_get_contents(database_path('data/koatuu.json')), true);

        $locations = $rootLocations['level1'];
        foreach ($locations as $firstLevelLocation) {
            $locationModelLevel1 = $this->createLocation([
                'name' => $firstLevelLocation['name'],
                'code' => $firstLevelLocation['code'],
                'type_id' => Location::REGION_TYPE,
                'path' => '/'
            ]);
            if (isset($firstLevelLocation['level2'])) {
                foreach ($firstLevelLocation['level2'] as $secondLevelLocation) {
                    $locationModelLevel2 = $this->createLocation([
                        'name' => $secondLevelLocation['name'],
                        'code' => $secondLevelLocation['code'],
                        'type_id' => Location::CITY_TYPE,
                        'parent_id' => $locationModelLevel1->id,
                        'path' => $locationModelLevel1->path . $locationModelLevel1->id . "/",
                    ]);
                    if (isset($secondLevelLocation['level3'])) {
                        foreach ($secondLevelLocation['level3'] as $thirdLevelLocation) {
                            if (isset($thirdLevelLocation['type']) && $thirdLevelLocation['type'] == '') {
                                continue;
                            }
                            $locationModelLevel3 = $this->createLocation([
                                'name' => $thirdLevelLocation['name'],
                                'code' => $thirdLevelLocation['code'],
                                'type_id' => Location::AREA_TYPE,
                                'parent_id' => $locationModelLevel2->id,
                                'path' => $locationModelLevel2->path . $locationModelLevel2->id . "/",

                            ]);
                            if (isset($thirdLevelLocation['level4'])) {
                                foreach ($thirdLevelLocation['level4'] as $fourthLevelLocation) {
                                    if (isset($fourthLevelLocation['type']) && $fourthLevelLocation['type'] == '') {
                                        continue;
                                    }
                                    $this->createLocation([
                                        'name' => $fourthLevelLocation['name'],
                                        'code' => $fourthLevelLocation['code'],
                                        'type_id' => Location::VILLAGE_TYPE,
                                        'parent_id' => $locationModelLevel3->id,
                                        'path' => $locationModelLevel3->path . $locationModelLevel3->id . "/",
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    private function createLocation($data)
    {

        /**
         * CHANGING DATA BLOCK
         */
        if (strpos($data['name'],"МІСТА ОБЛАСНОГО ПІДПОРЯДКУВАННЯ") !== false) {
            return;
        }
        if (strpos($data['name'],"РАЙОНИ") !== false) {
            return;
        }

        if (strpos($data['name'],"/СМТ ")!== false) {
            $data['name'] = stristr($data['name'], '/СМТ ');
            $data['name'] = str_replace('/СМТ ', '', $data['name']);
        }

        if (strpos($data['name'],"/С.")!== false) {
            $data['name'] = stristr($data['name'], '/С.');
            $data['name'] = str_replace('/С.', '', $data['name']);
        }


        if ($data['type_id'] !== Location::REGION_TYPE) {
            if (strpos($data['name'],"РАЙОН")!== false) {
                $data['name'] = stristr($data['name'], '/', true);
            }

            if (strpos($data['name'],"М.")!== false) {
                $data['name'] = str_replace('M.', '', $data['name']);
                $data['name'] = str_replace('м.', '', $data['name']);
            }
        }


        if (
            $data['type_id'] === Location::REGION_TYPE
            && strpos($data['name'],"/")!== false
        ) {
            $data['name'] = stristr($data['name'], '/', true);
        } else {
            $data['name'] = str_replace('М.', '', $data['name']);
            $data['name'] = str_replace('м.', '', $data['name']);
        }

        $data['name'] = mb_convert_case(mb_strtolower($data['name']), MB_CASE_TITLE);
        //---------------------------------------------------------------------


        /**
         * CREATE LOCATION
         */
        $location = new Location;
        $location->name = $data['name'];
        $location->code = $data['code'];
        $location->path = $data['path'] ?? '';
        $location->type_id = $data['type_id'];
        $parentId = $data['parent_id'] ?? null;

        if ($parentId) {
            $location->parent_id = $parentId;
        }
        $location->save();
        return $location;
    }
}