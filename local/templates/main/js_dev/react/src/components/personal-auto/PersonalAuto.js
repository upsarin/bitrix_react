import React, {Component, createRef, useEffect, useState} from 'react';
import {sendRequest} from "../../tools";
import AutoForm from "../personal-auto/AutoForm";

const fetchSearchCar = (url, params, callback) => {
	async function fetchRequest(url, params, callback){
		if(url === null) url = '/local/tools/user_cars/index.php';
		try {
			const result = await sendRequest(url, {
				showLoader: true,
				body: params,
				type: 'POST'
			});
			const {data} = result;
			callback(data);
		}
		catch (e)
		{
		}
	}

	fetchRequest(url, params, callback).then(() => {});
}



const PersonalAuto = () => {
	const [userCarList, setUserCarList] = useState(null);
	const [editableCar, setEditableCar] = useState(null);
	const [formType, setFormType] = useState(null);
	const [deleteCarAction, setDeleteCarAction] = useState(false);
	const [userCarDeleteId, setUserCarDeleteId] = useState(null);

	useEffect(() => {
		fetchSearchCar(
		null, {
			'action': 'getUserCarList'
		}, (data) => {
			setUserCarList(data);
		});
	}, []);
	function UserCarListBlock({carList}) {
		return carList.map((item) => (
			<div key={item.ID} className="personal-card__auto-item" data-block_id={item.ID}>
				<div className="personal-card__auto-title">{item.UF_CAR_BRAND} {item.UF_CAR_MODEL} {item.UF_CAR_YEAR} {item.UF_CAR_EQUIPMENT_NAME}</div>
				<div className="buttons-block">
					<button className="btn btn_stroke icon-edit car-edit" onClick={() => {setEditableCar(item); setFormType('edit');}}>Редактировать</button>
					<button className="btn btn_stroke icon-delete car-delete" onClick={() => userCarDeleteFunc(item.ID)}>Удалить</button>
				</div>
			</div>
		));
	}

	function userCarDeleteFunc(itemID) {
		setDeleteCarAction(true);
		setUserCarDeleteId(itemID);
	}
	function userCarListDelete() {
		fetchSearchCar(
			null, {
				'action': 'deleteUserCar',
				'params': {"deleteCarID": userCarDeleteId},
			}, (data) => {
				updateCarList();
				setDeleteCarAction(false);
				setUserCarDeleteId(null);
			});
	}
	function updateCarList() {
		fetchSearchCar(
		null, {
			'action': 'getUserCarList'
		}, (listData) => {
			setUserCarList(listData);
		});
	}

	return (
		<>
			<div className="personal-card">
				<div className="personal-card__wrap">
					<div className="personal-card__title">Мои авто</div>
					<div className="personal-card__body">
						<div className="personal-card__auto" id="cart-list">
							{(Array.isArray(userCarList) && userCarList.length > 0) && (
								<UserCarListBlock carList={userCarList} />
							)}
						</div>
					</div>
					<div className="personal-card__footer">
						<button className="btn icon-car" id="car-add" onClick={() => setFormType("new")}>Добавить автомобиль</button>
					</div>
				</div>
			</div>
			{!!formType && (
				<AutoForm
					initialData={editableCar}
					onClose={() => {
						setFormType(null);
						setEditableCar(null);
					}}
					formTemplate={formType}
					onSuccess={() => {
						setFormType(null);
						setEditableCar(null);
						updateCarList();
					}}
				/>
			)}
			{!!deleteCarAction && (
				<>
				<div className="container-delete-modal">
					<div className="delete-modal-block">
						<p>Вы точно хотите удалить данный автомобиль из списка?</p>
						<div className="modal-btns">
							<button className="btn icon-car car-delete-modal-button" onClick={() => userCarListDelete()}>Удалить автомобиль</button>
							<button className="btn icon-car car-delete-close" onClick={() => setDeleteCarAction(false)}>Отмена</button>
						</div>
					</div>
				</div>
				</>
			)}
		</>
	);
}

export default PersonalAuto;