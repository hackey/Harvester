<?php

/**
 * This is the model class for table "printers".
 *
 * The followings are the available columns in table 'printers':
 * @property integer $id
 * @property integer $comp_id
 * @property string $printer_name
 * @property string $PortName_printers
 * @property string $PrintProcessor
 * @property string $HorizontalResolution_printers
 * @property string $VerticalResolution_printers
 * @property string $type_printers
 * @property string $date_kartridje_printer
 *
 * The followings are the available model relations:
 * @property Computers $comp
 */
class Printers extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Printers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'printers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('comp_id', 'required'),
			array('comp_id', 'numerical', 'integerOnly'=>true),			
			array('printer_name, PortName_printers, PrintProcessor, type_printers', 'length', 'max'=>255),
			array('HorizontalResolution_printers, VerticalResolution_printers, date_kartridje_printer', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, comp_id, printer_name, Capabilities, PortName_printers, PrintProcessor, HorizontalResolution_printers, VerticalResolution_printers, type_printers, date_kartridje_printer', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'comp' => array(self::BELONGS_TO, 'Computers', 'comp_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'comp_id' => 'Comp',
			'printer_name' => 'Наименование',
			'Capabilities' => 'Возможности',
			'PortName_printers' => 'Порт',
			'PrintProcessor' => 'Процессор',
			'HorizontalResolution_printers' => 'Горизонтальное разрешение',
			'VerticalResolution_printers' => 'Вертикальное разрешение',
			'type_printers' => 'Описание',
			'date_kartridje_printer' => 'Картридж',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('comp_id',$this->comp_id);
		$criteria->compare('printer_name',$this->printer_name,true);
		$criteria->compare('Capabilities',$this->Capabilities,true);
		$criteria->compare('PortName_printers',$this->PortName_printers,true);
		$criteria->compare('PrintProcessor',$this->PrintProcessor,true);
		$criteria->compare('HorizontalResolution_printers',$this->HorizontalResolution_printers,true);
		$criteria->compare('VerticalResolution_printers',$this->VerticalResolution_printers,true);
		$criteria->compare('type_printers',$this->type_printers,true);
		$criteria->compare('date_kartridje_printer',$this->date_kartridje_printer,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	protected function AfterFind() {
		$temp = explode(',',$this->Capabilities);		
		$this->Capabilities='';
		foreach ($temp as $val) {
			switch ($val) {			
				case 0:
					$this->Capabilities.='Некорректная информация. ';
					break;
				case 1:
					$this->Capabilities.='Разные. ';
					break;
				case 2:
					$this->Capabilities.='Цветная печать. ';
					break;
				case 3:
					$this->Capabilities.='Двусторонняя печать. ';
					break;
				case 4:
					$this->Capabilities.='Копир. ';
					break;
				case 5:
					$this->Capabilities.='Сортировка. ';
					break;
				case 6:
					$this->Capabilities.='Сшивание. ';
					break;
				case 7:
					$this->Capabilities.='Прозрачность печати. ';
					break;
				case 8:
					$this->Capabilities.='Перфорирование. ';
					break;
				case 9:
					$this->Capabilities.='Создание обложек. ';
					break;
				case 10:
					$this->Capabilities.='Связывание. ';
					break;
				case 11:
					$this->Capabilities.='Черно-белая печать. ';
					break;
				case 12:
					$this->Capabilities.='Одностороння печать. ';
					break;
				case 13:
					$this->Capabilities.='Двусторонная длинная печать. ';
					break;				
				case 14:
					$this->Capabilities.='Двусторонная короткая печать. ';
					break;				
				case 15:
					$this->Capabilities.='Портрет. ';
					break;
				case 16:
					$this->Capabilities.='Ландшафтная печать. ';
					break;
				case 17:
					$this->Capabilities.='Обратнай портрет. ';
					break;
				case 18:
					$this->Capabilities.='Обратная Ландшафтная печать. ';
					break;
				case 19:
					$this->Capabilities.='Высокое качество печати. ';
					break;
				case 20:
					$this->Capabilities.='Среднее качество печати. ';
					break;	
				case 21:
					$this->Capabilities.='Плохое качество печати. ';
					break;				
			}		
		}
	}
	
	public function scan($COM,$IDComp,$index=1)
	{			
		$i=1;
		foreach ($COM->instancesof ( 'Win32_Printer' ) as $Printer ) {				
			if ($index==$i && $Printer->Local) {
				$this->comp_id=$IDComp;				
				$this->printer_name=$Printer->Name;
				foreach ($Printer->Capabilities as $Capabilities) {
					$temp[]=$Capabilities;
				}
				$this->Capabilities=implode(',', $temp);
				unset ($Capabilities,$temp);
				$this->PortName_printers=$Printer->PortName;
				$this->PrintProcessor=$Printer->PrintProcessor;
				$this->HorizontalResolution_printers=$Printer->HorizontalResolution;				
				$this->VerticalResolution_printers=$Printer->VerticalResolution;				
				$this->type_printers=$Printer->Caption;				
				break;
			}
			$i++;
		}
	}
}