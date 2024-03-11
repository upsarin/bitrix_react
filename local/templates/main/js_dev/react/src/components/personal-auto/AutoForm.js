import React, {useEffect, useState} from 'react';
import Select from "../common/Select";
import {string} from "prop-types";
import {fetchSearch} from "../search-by-auto/SearchByAuto";
import {sendRequest} from "../../tools";

const fetchCarRequest = (url, params, callback) => {
	async function fetchCarRequest(url, params, callback){
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

	fetchCarRequest(url, params, callback).then(() => {});
}

const AutoForm = ({initialData = null, formTemplate=null, onSuccess, onClose}) => {
	const [errorMsg, setErrorMsg] = useState(null);
	// для полей
	const [makes, setMakes] = useState([]);
	const [models, setModels] = useState([]);
	const [years, setYears] = useState([]);
	const [modifications, setModifications] = useState([]);
	const [selectedMake, setSelectedMake] = useState(initialData?.UF_CAR_BRAND || null);
	const [selectedModel, setSelectedModel] = useState(initialData?.UF_CAR_MODEL || null);
	const [selectedYear, setSelectedYear] = useState(initialData?.UF_CAR_YEAR || null);
	const [selectedModification, setSelectedModification] = useState(initialData?.UF_CAR_EQUIPMENT || null);
	const [selectedModificationName, setSelectedModificationName] = useState(initialData?.UF_CAR_EQUIPMENT_NAME || null);


	useEffect(() => {
		fetchSearch(null, {
			'action': 'getMakes'
		}, (data) => {
			if (Array.isArray(data)) setMakes(data);
		});
	}, []);

	useEffect(() => {
		if(selectedMake) {
			fetchSearch(null, {
				'action': 'getModels',
				'make': selectedMake
			}, (data) => {
				if (Array.isArray(data)) setModels(data);
			});
		}
	}, [selectedMake]);

	useEffect(() => {
		if(selectedMake && selectedModel) {
			fetchSearch(null,{
				'action': 'getYears',
				'make': selectedMake,
				'model': selectedModel
			}, (data) => {
				if (Array.isArray(data)) setYears(data);
			});
		}
	}, [selectedMake, selectedModel]);

	useEffect(() => {
		if(selectedMake && selectedModel && selectedYear) {
			fetchSearch(null, {
				'action': 'getModifications',
				'make': selectedMake,
				'model': selectedModel,
				'year': selectedYear
			}, (data) => {
				if (Array.isArray(data)) setModifications(data);
			});
		}
	}, [selectedMake, selectedModel, selectedYear]);

	useEffect(() => {
		if(selectedMake === null) {
			setSelectedModel(null);
			setModels(models);
		}
	}, [selectedMake]);

	useEffect(() => {
		if(selectedModel === null) {
			setSelectedYear(null);
			setYears(years);
		}
	}, [selectedModel]);

	useEffect(() => {
		if(selectedYear === null) {
			setSelectedModification(null);
			setModifications([]);
		}
	}, [selectedYear]);

	useEffect(() => {
		if(selectedModification === null) {
			setSelectedModification(null);
			setSelectedModificationName(null);
			setModifications(modifications);
		}
	}, [selectedModification]);

	useEffect(() => {
		if(formTemplate === "new") {
			setSelectedMake(null);
		} else {
			setSelectedMake(initialData?.UF_CAR_BRAND || null);
			setSelectedModel(initialData?.UF_CAR_MODEL || null);
			setSelectedYear(initialData?.UF_CAR_YEAR || null);
			setSelectedModification(initialData?.UF_CAR_EQUIPMENT || null);
			setSelectedModificationName(initialData?.UF_CAR_EQUIPMENT_NAME || null);
		}
	}, [initialData, formTemplate]);

	const makesOptions = makes.map((item) => ({label: item.name, value: item.name, make: item}));
	const makesDefaultOptions = selectedMake && makesOptions.filter(item => item.value === selectedMake);

	const modelsOptions = models.map((item) => ({label: item.name, value: item.name, model: item}));
	const modelsDefaultOptions = selectedModel && modelsOptions.filter(item => item.value === selectedModel);

	const yearsOptions = years.map((item) => ({label: item.name, value: item.name, year: item}));
	const yearsDefaultOptions = selectedYear && yearsOptions.filter(item => item.value === (selectedYear*1));

	const modificationsOptions = modifications.map((item) => ({label: item.name, value: item.slug, modification: item}));
	const modificationsDefaultOptions = selectedModification && modificationsOptions.filter(item => item.value === selectedModification);

	const selectMakeElement = (<Select
		onChange={option => setSelectedMake(option.make.name)}
		key={selectedMake}
		options={makesOptions}
		defaultValues={makesDefaultOptions || []}
		onResetFilterBlock={() => setSelectedMake(null)}
	/>);
	const selectModelElement = (<Select
		onChange={option => setSelectedModel(option.model.name)}
		key={selectedModel}
		options={modelsOptions}
		defaultValues={modelsDefaultOptions || []}
		onResetFilterBlock={() => setSelectedModel(null)}
	/>);
	const selectYearElement = (<Select
		onChange={option => setSelectedYear(option.year.name)}
		key={selectedYear}
		options={yearsOptions}
		defaultValues={yearsDefaultOptions || []}
		onResetFilterBlock={() => setSelectedYear(null)}
	/>);
	const selectModificationElement = (<Select
		onChange={option => {
			setSelectedModification(option.modification.slug);
			setSelectedModificationName(option.modification.name);
		}}
		key={selectedModification}
		options={modificationsOptions}
		defaultValues={modificationsDefaultOptions || []}
		onResetFilterBlock={() => setSelectedModification(null)}
	/>);

	const onClickSave = e => {
		if(selectedMake !== null && selectedModel !== null && selectedYear !== null && selectedModification !== null && selectedModificationName !== null)
		{
			fetchCarRequest(
				'/local/tools/user_cars/index.php', {
					'action': (formTemplate === "new") ? 'saveUserCar' : 'updateUserCar',
					'params': {
						id: (formTemplate === "new") ? null : initialData.ID,
						make: selectedMake,
						model: selectedModel,
						year: selectedYear,
						modification: selectedModification,
						modificationName: selectedModificationName,
					},
				}, (data) => {
					if(data.error)
					{
						setErrorMsg(data.errorMessage);
					}
					else
					{
						onSuccess();
					}
				});
		}
		else
		{
			setErrorMsg("Не заполнены все обязательные поля!");
		}
	}

	return (
		<div className="personal-card personal-card_car personal-cars-edit">
			<div className="personal-card__wrap">
				<div className="personal-card__title tyresaddict-output-title">{(formTemplate === "new") ? "Добавление" : "Редактирование"} автомобиля</div>
				<div className="personal-card__body">
					<form className="form personal-card-form tyresaddict-form no-fill">
						<div className="form__body">
							<div className="form__item">
								<div className="form-field form-field-brands disabled" data-action="brands">
									<div className="form-field__title">Марка</div>
									{selectMakeElement}
								</div>
							</div>

							<div className="form__item">
								<div className="form-field form-field-brands disabled" data-action="models">
									<div className="form-field__title">Модель</div>
									{selectModelElement}
								</div>
							</div>

							<div className="form__item">
								<div className="form-field form-field-brands disabled" data-action="year">
									<div className="form-field__title">Год выпуска</div>
									{selectYearElement}
								</div>
							</div>

							<div className="form__item">
								<div className="form-field form-field-brands disabled" data-action="modifications">
									<div className="form-field__title">Комплектация</div>
									{selectModificationElement}
								</div>
							</div>
						</div>
						<div className="form__footer">
							<button className="btn" type="button" onClick={onClickSave}>Сохранить изменения</button>
							<button className="btn btn_delete" type="button" onClick={e => onClose()}>Закрыть</button>
							{!!errorMsg && (
								<p className="error personal-error" id="personal-car-error">{errorMsg}</p>
							)}
						</div>
					</form>
				</div>
			</div>
		</div>
	);
};

export default AutoForm;