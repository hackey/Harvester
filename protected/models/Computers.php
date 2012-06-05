<?php

/**
 * This is the model class for table "Computers".
 *
 * The followings are the available columns in table 'Computers':
 * @property integer $id
 * @property string $name
 * @property string $ip
 * @property string $Domain
 * @property string $Department
 *
 * The followings are the available model relations:
 * @property BIOS[] $bIOSes
 * @property Memory[] $memories
 * @property SoundDevice[] $soundDevices
 * @property AntivirusSoftware[] $antivirusSoftwares
 * @property CdDrives[] $cdDrives
 * @property Monitors[] $monitors
 * @property Motherboards[] $motherboards
 * @property NetworkAdapters[] $networkAdapters
 * @property Os[] $oses
 * @property PhysicalDrives[] $physicalDrives
 * @property Printers[] $printers
 * @property Processors[] $processors
 * @property Software[] $softwares
 * @property Videoadapters[] $videoadapters
 */
class Computers extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Computers the static model class
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
		return 'Computers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>20),
			array('ip', 'length', 'max'=>15),
			array('Domain', 'length', 'max'=>63),
			array('Department', 'length', 'max'=>50),
			array('user', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, user, ip, Domain, DomainName, Department', 'safe', 'on'=>'search'),
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
			'bIOSes' => array(self::HAS_MANY, 'BIOS', 'comp_id'),
            'memories' => array(self::HAS_MANY, 'Memory', 'comp_id'),
            'soundDevices' => array(self::HAS_MANY, 'SoundDevice', 'comp_id'),
            'antivirusSoftwares' => array(self::HAS_MANY, 'AntivirusSoftware', 'comp_id'),
            'cdDrives' => array(self::HAS_MANY, 'CdDrives', 'comp_id'),
            'monitors' => array(self::HAS_MANY, 'Monitors', 'comp_id'),
            'motherboards' => array(self::HAS_MANY, 'Motherboards', 'comp_id'),
            'inputDevices' => array(self::HAS_MANY, 'InputDevice', 'comp_id'),
            'networkAdapters' => array(self::HAS_MANY, 'NetworkAdapters', 'comp_id'),
            'oses' => array(self::HAS_MANY, 'Os', 'comp_id'),
            'physicalDrives' => array(self::HAS_MANY, 'PhysicalDrives', 'comp_id'),
            'printers' => array(self::HAS_MANY, 'Printers', 'comp_id'),
            'processors' => array(self::HAS_MANY, 'Processors', 'comp_id'),
            'softwares' => array(self::HAS_MANY, 'Software', 'comp_id'),
            'videoadapters' => array(self::HAS_MANY, 'Videoadapters', 'comp_id'),			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Имя компьютера',
			'ip' => 'IP адрес',
			'Domain' => 'Имя DNS',
			'DomainName' => 'Имя домена',
			'Department' => 'Отдел',
			'user' => 'Пользователь',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('Domain',$this->Domain,true);
		$criteria->compare('DomainName',$this->DomainName,true);
		$criteria->compare('Department',$this->Department,true);
		$criteria->compare('user',$this->user,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	protected function beforeSave()
	{		
		$this->ip=ip2long($this->ip);
		return true;
	}
	
	protected function afterSave()
	{
		parent::afterSave();
		Departments::model()->AddDepartment($this->Department);
	}
	
	public function scanner($Domain)
	{
		$comp=file('assets/' . $Domain . '.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		return $comp;
	}
	
	protected function clearValue($model)
	{
		$attributes=array_slice($model->attributeNames(), 2);
		$model->unsetAttributes($attributes);		
	}
	
	public function scan($NameComp)	{
	
		$COM = new COM ( 'winmgmts:{impersonationLevel=impersonate}//'. $NameComp .'/root/cimv2' );				
		
		$this->name=$NameComp;
		unset($this->DomainName,$this->Domain,$this->ip);	
		$this->ip=gethostbyname($NameComp);		
		$this->Domain=gethostbyaddr($this->ip);		
		foreach ($COM->instancesof ( 'Win32_NTDomain' ) as $NTDomain ) {				
			if($NTDomain->Status=='OK') {
				$this->DomainName=$NTDomain->DomainName;				
				break;
			}			
		}		
		
		if (!$this->save() && !Yii::app()->request->isAjaxRequest)		
			throw new CHttpException(404,'Ошибка получения данных');
		
		$temp=Processors::model()->find('comp_id=:comp_id', array(':comp_id'=>$this->id));
		(isset($temp)) ? $proc=$temp : $proc = new Processors;		
		$this->clearValue($proc);
		$proc->scan($COM,$this->id);		
		if (!$proc->save() && !Yii::app()->request->isAjaxRequest)		
			throw new CHttpException(404,'Ошибка получения данных о процессоре');
			
		$temp=Motherboards::model()->find('comp_id=:comp_id', array(':comp_id'=>$this->id));
		(isset($temp)) ? $Motherboards=$temp : $Motherboards = new Motherboards;			
		$this->clearValue($Motherboards);
		$Motherboards->scan($COM,$this->id);		
		if (!$Motherboards->save() && !Yii::app()->request->isAjaxRequest)		
			throw new CHttpException(404,'Ошибка получения данных о системной плате');
			
		$temp=InputDevice::model()->find('comp_id=:comp_id', array(':comp_id'=>$this->id));
		(isset($temp)) ? $InputDevice=$temp : $InputDevice = new InputDevice;			
		$this->clearValue($InputDevice);
		$InputDevice->scan($COM,$this->id);		
		if (!$InputDevice->save() && !Yii::app()->request->isAjaxRequest)		
			throw new CHttpException(404,'Ошибка получения данных о клавиатуре или мыши');
				
		
		
		// --------------------------BIOS----------------------------
		$count=0;
		foreach ($COM->instancesof ( 'Win32_BIOS' ) as $BIOS ) {				
			$count++;
		} unset($BIOS);		
		$Data=new CActiveDataProvider('BIOS',array(
			'criteria'=>array(
				'condition'=>'comp_id='.$this->id,						
			),
			'pagination'=>false,
		));		
		$countInBD=$Data->getTotalItemCount();				
		while ($count<$countInBD) {			
			$countInBD--;
			$Data->data[$countInBD]->delete();			
		}		
		$i=1;			
		foreach($Data->getData() as $thisArray) {				
			$this->clearValue($thisArray);
			$thisArray->scan($COM,$this->id,$i);
			if (!$thisArray->save() && !Yii::app()->request->isAjaxRequest) 
				throw new CHttpException(404,'Ошибка при получении информации о BIOS');
			$i++;				
		}
		unset($thisArray);
		while ($i<=$count) {
			$thisArray=new BIOS;			
			$thisArray->scan($COM,$this->id,$i);
			if (!$thisArray->save() && !Yii::app()->request->isAjaxRequest) 
				throw new CHttpException(404,'Ошибка при получении информации о BIOS');
			$i++;
		}		
			
		// --------------------------CDROMDrive----------------------------
		$count=0;
		foreach ($COM->instancesof ( 'Win32_CDROMDrive' ) as $CDROMDrive ) {				
			$count++;
		} unset($CDROMDrive);		
		$Data=new CActiveDataProvider('CdDrives',array(
			'criteria'=>array(
				'condition'=>'comp_id='.$this->id,						
			),
			'pagination'=>false,
		));		
		$countInBD=$Data->getTotalItemCount();				
		while ($count<$countInBD) {			
			$countInBD--;
			$Data->data[$countInBD]->delete();			
		}		
		$i=1;			
		foreach($Data->getData() as $thisArray) {				
			$this->clearValue($thisArray);
			$thisArray->scan($COM,$this->id,$i);
			if (!$thisArray->save() && !Yii::app()->request->isAjaxRequest) 
				throw new CHttpException(404,'Ошибка при получении информации о CDROMDrive');
			$i++;				
		}
		unset($thisArray);
		while ($i<=$count) {
			$thisArray=new CdDrives;			
			$thisArray->scan($COM,$this->id,$i);
			if (!$thisArray->save() && !Yii::app()->request->isAjaxRequest) 
				throw new CHttpException(404,'Ошибка при получении информации о CDROMDrive');
			$i++;
		}					
		
		// --------------------------Memory----------------------------		
		$count=0;
		foreach ($COM->instancesof ( 'Win32_PhysicalMemory' ) as $Memory) {				
			$count++;
		} unset($Memory);		
		$Data=new CActiveDataProvider('Memory',array(
			'criteria'=>array(
				'condition'=>'comp_id='.$this->id,						
			),
			'pagination'=>false,
		));		
		$countInBD=$Data->getTotalItemCount();				
		while ($count<$countInBD) {			
			$countInBD--;
			$Data->data[$countInBD]->delete();			
		}		
		$i=1;			
		foreach($Data->getData() as $thisArray) {				
			$this->clearValue($thisArray);
			$thisArray->scan($COM,$this->id,$i);
			if (!$thisArray->save() && !Yii::app()->request->isAjaxRequest) 
				throw new CHttpException(404,'Ошибка при получении информации о Memory');
			$i++;				
		}
		unset($thisArray);
		while ($i<=$count) {
			$thisArray=new Memory;			
			$thisArray->scan($COM,$this->id,$i);
			if (!$thisArray->save() && !Yii::app()->request->isAjaxRequest) 
				throw new CHttpException(404,'Ошибка при получении информации о Memory');
			$i++;
		}
		
		// --------------------------PhysicalDrives----------------------------		
		$count=0;
		foreach ($COM->instancesof ( 'Win32_DiskDrive' ) as $PhysicalDrives) {				
			$count++;
		} unset($PhysicalDrives);		
		$Data=new CActiveDataProvider('PhysicalDrives',array(
			'criteria'=>array(
				'condition'=>'comp_id='.$this->id,						
			),
			'pagination'=>false,
		));		
		$countInBD=$Data->getTotalItemCount();				
		while ($count<$countInBD) {			
			$countInBD--;
			$Data->data[$countInBD]->delete();			
		}		
		$i=1;			
		foreach($Data->getData() as $thisArray) {				
			$this->clearValue($thisArray);
			$thisArray->scan($COM,$this->id,$i);
			if (!$thisArray->save() && !Yii::app()->request->isAjaxRequest) 
				throw new CHttpException(404,'Ошибка при получении информации о PhysicalDrives');
			$i++;				
		}
		unset($thisArray);
		while ($i<=$count) {
			$thisArray=new PhysicalDrives;
			$thisArray->scan($COM,$this->id,$i);
			if (!$thisArray->save() && !Yii::app()->request->isAjaxRequest) 
				throw new CHttpException(404,'Ошибка при получении информации о PhysicalDrives');
			$i++;
		}
		
		// --------------------------soundDevices----------------------------		
		$count=0;
		foreach ($COM->instancesof ( 'Win32_SoundDevice' ) as $SoundDevice) {				
			$count++;
		} unset($SoundDevice);		
		$Data=new CActiveDataProvider('SoundDevice',array(
			'criteria'=>array(
				'condition'=>'comp_id='.$this->id,						
			),
			'pagination'=>false,
		));		
		$countInBD=$Data->getTotalItemCount();				
		while ($count<$countInBD) {			
			$countInBD--;
			$Data->data[$countInBD]->delete();			
		}		
		$i=1;			
		foreach($Data->getData() as $thisArray) {				
			$this->clearValue($thisArray);
			$thisArray->scan($COM,$this->id,$i);
			if (!$thisArray->save() && !Yii::app()->request->isAjaxRequest) 
				throw new CHttpException(404,'Ошибка при получении информации о SoundDevice');
			$i++;				
		}
		unset($thisArray);
		while ($i<=$count) {
			$thisArray=new SoundDevice;
			$thisArray->scan($COM,$this->id,$i);
			if (!$thisArray->save() && !Yii::app()->request->isAjaxRequest) 
				throw new CHttpException(404,'Ошибка при получении информации о SoundDevice');
			$i++;
		}
		
		// --------------------------DesktopMonitor----------------------------		
		$count=0;
		foreach ($COM->instancesof ( 'Win32_DesktopMonitor' ) as $Monitors) {				
			$count++;
		} unset($Monitors);		
		$Data=new CActiveDataProvider('Monitors',array(
			'criteria'=>array(
				'condition'=>'comp_id='.$this->id,						
			),
			'pagination'=>false,
		));		
		$countInBD=$Data->getTotalItemCount();				
		while ($count<$countInBD) {			
			$countInBD--;
			$Data->data[$countInBD]->delete();			
		}		
		$i=1;			
		foreach($Data->getData() as $thisArray) {				
			$this->clearValue($thisArray);
			$thisArray->scan($COM,$this->id,$i);
			if (!$thisArray->save() && !Yii::app()->request->isAjaxRequest) 
				throw new CHttpException(404,'Ошибка при получении информации о Monitors');
			$i++;				
		}
		unset($thisArray);
		while ($i<=$count) {
			$thisArray=new Monitors;
			$thisArray->scan($COM,$this->id,$i);
			if (!$thisArray->save() && !Yii::app()->request->isAjaxRequest) 
				throw new CHttpException(404,'Ошибка при получении информации о Monitors');
			$i++;
		}
		
		// --------------------------NetworkAdapters----------------------------		
		$temp=NetworkAdapters::model()->find('comp_id=:comp_id', array(':comp_id'=>$this->id));
		(isset($temp)) ? $NetworkAdapters=$temp : $NetworkAdapters = new NetworkAdapters;	
		$this->clearValue($NetworkAdapters);
		$NetworkAdapters->scan($COM,$this->id);		
		if (!$NetworkAdapters->save() && !Yii::app()->request->isAjaxRequest)		
			throw new CHttpException(404,'Ошибка получения данных о NetworkAdapters');		
		
		// --------------------------Os----------------------------		
		$count=0;
		foreach ($COM->instancesof ( 'Win32_OperatingSystem' ) as $Os) {		
			$count++;			
		} unset($Os);		
		$Data=new CActiveDataProvider('Os',array(
			'criteria'=>array(
				'condition'=>'comp_id='.$this->id,						
			),
			'pagination'=>false,
		));		
		$countInBD=$Data->getTotalItemCount();				
		while ($count<$countInBD) {			
			$countInBD--;
			$Data->data[$countInBD]->delete();			
		}		
		$i=1;			
		foreach($Data->getData() as $thisArray) {				
			$this->clearValue($thisArray);
			$thisArray->scan($COM,$this->id,$i);
			if (!$thisArray->save() && !Yii::app()->request->isAjaxRequest) 
				throw new CHttpException(404,'Ошибка при получении информации о OC');
			$i++;				
		}
		unset($thisArray);
		while ($i<=$count) {
			$thisArray=new Os;
			$thisArray->scan($COM,$this->id,$i);
			if (!$thisArray->save() && !Yii::app()->request->isAjaxRequest) 
				throw new CHttpException(404,'Ошибка при получении информации о OC');
			$i++;
		}		
			
		// --------------------------Printers----------------------------		
		$count=0;
		foreach ($COM->instancesof ( 'Win32_Printer' ) as $Printers) {		
			if ($Printers->Local) 
				$count++;			
		} 
		unset($Printers);		
		$Data=new CActiveDataProvider('Printers',array(
			'criteria'=>array(
				'condition'=>'comp_id='.$this->id,						
			),
			'pagination'=>false,
		));		
		$countInBD=$Data->getTotalItemCount();						
		while ($Data->getTotalItemCount(true)<$count) {
			$thisArray=new Printers;			
			$thisArray->scan($COM,$this->id,$Data->getTotalItemCount(true)+1);
			if (!$thisArray->save() && !Yii::app()->request->isAjaxRequest) 
				throw new CHttpException(404,'Ошибка при получении информации о Принтерах');				
		}			
		while ($Data->getTotalItemCount(true)>$count) {				
			$Data->data[$Data->getTotalItemCount(true)-1]->delete();			
		}
		$i=1;
		foreach($Data->getData() as $thisArray) {				
			$this->clearValue($thisArray);
			$thisArray->scan($COM,$this->id,$i);
			if (!$thisArray->save() && !Yii::app()->request->isAjaxRequest) 
				throw new CHttpException(404,'Ошибка при получении информации о Принтерах');
			$i++;
		}
		unset($thisArray);
			
		// --------------------------Videoadapters----------------------------		
		$count=0;
		foreach ($COM->instancesof ( 'Win32_VideoController' ) as $Videoadapters) {
			if ($Videoadapters->Availability==3) {
				$count++;
			}
		}
		unset($Videoadapters);
		$Data=new CActiveDataProvider('Videoadapters',array(
			'criteria'=>array(
				'condition'=>'comp_id='.$this->id,						
			),
			'pagination'=>false,
		));								
		while ($Data->getTotalItemCount(true)<$count) {
			$thisArray=new Videoadapters;			
			$thisArray->scan($COM,$this->id,$Data->getTotalItemCount(true)+1);
			if (!$thisArray->save() && !Yii::app()->request->isAjaxRequest) 
				throw new CHttpException(404,'Ошибка при получении информации о Видеоадаптаре');				
		}			
		while ($Data->getTotalItemCount(true)>$count) {				
			$Data->data[$Data->getTotalItemCount(true)-1]->delete();			
		}
		$i=1;
		foreach($Data->getData() as $thisArray) {				
			$this->clearValue($thisArray);
			$thisArray->scan($COM,$this->id,$i);
			if (!$thisArray->save() && !Yii::app()->request->isAjaxRequest) 
				throw new CHttpException(404,'Ошибка при получении информации о Видеоадаптаре');
			$i++;
		}
		unset($thisArray);

		return true;
	}
}