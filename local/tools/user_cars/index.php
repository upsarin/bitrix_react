<?
require $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php';
$resultData = [];
$action = $_REQUEST['action'];
$params = $_REQUEST['params'];

if($action != "" && !empty($action))
{
	global $USER;
	if($USER->IsAuthorized())
	{
		if($action == "getUserCarList")
		{
			$result = \MH\Car::getCars($USER->GetID());
		}
		else if($action == "saveUserCar" && is_array($params))
		{
			$result = \MH\Car::addCar($USER->GetID(), $params);
		}
		else if($action == "deleteUserCar" && !empty($params['deleteCarID']))
		{
			$result = \MH\Car::deleteCar($USER->GetID(), $params['deleteCarID']);
		}
		else if($action == "updateUserCar" && !empty($params['id']))
		{
			$result = \MH\Car::updateCar($USER->GetID(), $params);
		}
		else if($action == "getModificationName")
		{
			$result = \MH\WheelSizeProducts::getModificationName($params);
		}

		if(is_array($result))
		{
			$resultData = json_encode($result);
		}
	}
	else
	{
		$resultData['error'] = true;
		$resultData['errorMessage'] = 'Пожалуйста, авторизуйтесь';
	}
}
echo $resultData;