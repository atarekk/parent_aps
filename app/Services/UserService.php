<?php


namespace App\Services;


use App\Traits\UserDataTrait;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserService
{
    use UserDataTrait;


    /**get users from json files and merge it
     * @return JsonResponse
     * @throws FileNotFoundException
     */
    function getAllUsers()
    {
        $dataProviderX = $this->getUserDataProvider("DataProviderX");
        $dataProviderY = $this->getUserDataProvider("DataProviderY");
        $users = $dataProviderX->mergeRecursive($dataProviderY);
        return response()->json($users);
    }

    /**
     * @param Request $filter
     * @return JsonResponse
     */
    public function filter(Request $filter)
    {
        try {
            $dataProviderX = $this->getUserDataProvider("DataProviderX");
            $dataProviderY = $this->getUserDataProvider("DataProviderY");;
            if ($filter->filled("provider") && ($filter->provider == "DataProviderX" || $filter->provider == "DataProviderY")) {
                $users = $this->getUserDataProvider($filter->provider);
            } else {
                $users = $dataProviderX->mergeRecursive($dataProviderY);
            }
            if ($filter->filled("balanceMin") && $filter->filled("balanceMax")) {
                $users = $this->filterByBalance($users, $filter);

            }
            if ($filter->filled("statusCode")) {
                $users = $this->filterByStatusCode($users, $filter);
            }
            if ($filter->filled("currency")) {
                $users = $this->filterByCurrency($users, $filter);
            }
            $users = array_values($users->all());

            return response()->json(["success" => true, "users" => $users], 200);
        } catch (\Exception $exception) {
            return response()->json(["success" => false, "users" => "users not found"], 404);
        }
    }

    /**
     * @param $users
     * @param Request $filter
     * @return mixed
     */
    private function filterByBalance($users, Request $filter)
    {
        $filtered = $users->filter(function ($range, $key) use ($filter) {
            if (isset($range["parentAmount"])) {
                if ($range["parentAmount"] >= (float)$filter->balanceMin && $range["parentAmount"] <= (float)$filter->balanceMax) {
                    return $range["parentAmount"];
                }
            }
            if (isset($range["balance"])) {
                if ($range["balance"] >= (float)$filter->balanceMin && $range["balance"] <= (float)$filter->balanceMax) {
                    return $range["balance"];
                }
            }

        });
        return $filtered;
    }

    /**
     * @param $users
     * @param Request $filter
     * @return mixed
     */
    private function filterByStatusCode($users, Request $filter)
    {
        $filtered = $users->filter(function ($range, $key) use ($filter) {
            if (isset($range["statusCode"])) {
                if (in_array($filter->statusCode, array_keys(config("constant.dataProviderXstatus")))) {
                    return $range["statusCode"] == config("constant.dataProviderXstatus.$filter->statusCode");
                }
            }
            if (isset($range["status"])) {
                if (in_array($filter->statusCode, array_keys(config("constant.dataProviderYstatus")))) {
                    return $range["status"] == config("constant.dataProviderYstatus.$filter->statusCode");;
                }
            }

        });
        return $filtered;
    }

    /**
     * @param $users
     * @param $filter
     * @return mixed
     */
    private function filterByCurrency($users, Request $filter)
    {
        $filtered = $users->filter(function ($range, $key) use ($filter) {

            if (isset($range["Currency"])) {
                if ($range["Currency"] == $filter->currency) {

                    return $range["Currency"];
                }
            }
            if (isset($range["currency"])) {
                if ($range["currency"] == $filter->currency) {

                    return $range["currency"];
                }
            }

        });
        return $filtered;
    }
}
