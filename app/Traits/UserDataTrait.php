<?php


namespace App\Traits;


use Illuminate\Support\Facades\Storage;

trait UserDataTrait
{
    /**
     * @param string $dataProvider
     * @return bool|\Illuminate\Support\Collection
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    function getUserDataProvider(string $dataProvider)
    {
        $dataProviderFile = Storage::disk("public")->exists("$dataProvider.json");

        if ($dataProviderFile) {
            $dataProvider = Storage::disk("public")->get("$dataProvider.json");
            $dataProvider = json_decode($dataProvider,true);
            return collect($dataProvider["users"]);
        }
        return false;

    }


}
