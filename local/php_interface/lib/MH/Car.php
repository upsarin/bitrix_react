<?php
namespace MH;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\Loader;
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;

\Bitrix\Main\Loader::includeModule('highloadblock');

class Car
{
	const HIGHLOAD_BLOCK_ID = 5;

	/**
	 * @return \Bitrix\Main\ORM\Data\DataManager|string
	 */
	private static function hlBlockEntity()
	{
		$hlBlock = HLBT::getById(self::HIGHLOAD_BLOCK_ID)->fetch();
		$entity = HLBT::compileEntity($hlBlock);
		$entityDataClass = $entity->getDataClass();
		unset($hlBlock, $entity);
		return $entityDataClass;
	}

	public static function getCars(int $userID) :array
	{
		$entityDataClass = self::hlBlockEntity();
		return $entityDataClass::getList([
			'select' => ['*'],
			'filter' => ['UF_CAR_USER_ID' => $userID]
		])->fetchAll();
	}

	public static function addCar(int $userID, array $params) :array
	{
		$resultData = [];
		if (!isset($params['make'], $params['model'], $params['year'], $params['modification'], $params['modificationName']))
		{
			$resultData['errorMessage'] = 'Не переданы обязательные поля';
			$resultData['error'] = true;
		}
		else
		{
			$filter = ['UF_CAR_BRAND'     => $params['make'],
					   'UF_CAR_MODEL'     => $params['model'],
					   'UF_CAR_YEAR'      => $params['year'],
					   'UF_CAR_EQUIPMENT' => $params['modification'],
					   'UF_CAR_EQUIPMENT_NAME' => $params['modificationName'],
					   'UF_CAR_USER_ID'   => $userID
			];

			$car = static::getCar($filter);
			if(is_array($car) && !empty($car['ID']))
			{
				$resultData['error'] = true;
				$resultData['errorMessage'] = "Такой автомобиль уже добавлен";
			}
			else
			{
				$entityDataClass = self::hlBlockEntity();
				$result = $entityDataClass::add([
					'UF_CAR_BRAND'     => $params['make'],
					'UF_CAR_MODEL'     => $params['model'],
					'UF_CAR_YEAR'      => $params['year'],
					'UF_CAR_EQUIPMENT' => $params['modification'],
					'UF_CAR_EQUIPMENT_NAME' => $params['modificationName'],
					'UF_CAR_USER_ID'   => $userID
				]);
				if($result->isSuccess())
				{
					$resultData['error'] = false;
				}
				else
				{
					$resultData['errorMessage'] = 'Ошибка добавления автомобиля';
					$resultData['bx_error'] = $result->getErrorMessages();
					$resultData['error'] = true;
				}
			}
		}
		return $resultData;
	}

	public static function deleteCar(int $userID, int $deleteID) :array
	{
		$resultData = [];
		if(!empty($userID) && !empty($deleteID))
		{
			$entityDataClass = self::hlBlockEntity();
			$result = $entityDataClass::Delete($deleteID);
			if($result->isSuccess())
			{
				$resultData['error'] = false;
			}
			else
			{
				$resultData['errorMessage'] = 'Ошибка удаления автомобиля';
				$resultData['bx_error'] = $result->getErrorMessages();
				$resultData['error'] = true;
			}
		}
		else
		{
			$resultData['errorMessage'] = 'Не передан ID автомобиля для удаления';
			$resultData['error'] = true;
		}
		return $resultData;
	}
	public static function updateCar(int $userID, array $params) :array
	{
		$resultData = [];
		if (!isset($params['make'], $params['model'], $params['year'], $params['modification'], $params['id']))
		{
			$resultData['errorMessage'] = 'Не переданы обязательные поля для обновления';
			$resultData['error'] = true;
		}
		else
		{
			$car = static::getCar(['ID' => $params['id']]);
			if(!is_array($car) && empty($car['ID']))
			{
				$resultData['errorMessage'] = 'Указанная машина не найдена';
				$resultData['error'] = true;
			}
			else
			{
				if($car['UF_CAR_USER_ID'] == $userID)
				{
					$entityDataClass = self::hlBlockEntity();
					$result = $entityDataClass::update($params['id'], [
						'UF_CAR_BRAND'     => $params['make'],
						'UF_CAR_MODEL'     => $params['model'],
						'UF_CAR_YEAR'      => $params['year'],
						'UF_CAR_EQUIPMENT' => $params['modification'],
						'UF_CAR_USER_ID'   => $userID
					]);

					if($result->isSuccess())
					{
						$resultData['error'] = false;
					}
					else
					{
						$resultData['errorMessage'] = 'Ошибка обновления автомобиля при сохранении';
						$resultData['bx_error'] = $result->getErrorMessages();
						$resultData['error'] = true;
					}
				}
				else
				{
					$resultData['errorMessage'] = 'Данный автомобиль не принадлежит текущему пользователю';
					$resultData['error'] = true;
				}
			}
		}
		return $resultData;
	}

	/**
	 * @return array|null
	 */
	public static function getCar(array $filter)
	{
		$entityDataClass = self::hlBlockEntity();
		return $entityDataClass::getList([
			'select' => ['*'],
			'filter' => $filter
		])->fetch();
	}
}
