# FIX SAAS


### JWT Actions
```php

    // Create Token
    JWTProvider::createToken($secureStatus,$tokenType,$tokenDataArray);
            

    JWTProvider::verifyToken(JWTProvider::TYPE_COMPANY);

    // TOKEN TYPES
    JWTProvider::TYPE_ADMIN
    JWTProvider::TYPE_COMPANY
    JWTProvider::TYPE_API

    // Secure Type
    // If you use IS_SECURE check token create ip and current ip
    JWTProvider::IS_SECURE
    JWTProvider::NON_SECURE
    

```

### Response Access
```php
    Response::make("TITLE","MESSAGE",[])->success();
    Response::make("TITLE","MESSAGE",[])->error();
    Response::make("TITLE","MESSAGE",[])->warning();
    
    // ->success()
    // ->error()
    // ->warning()
```

### Plugin System Access
```php
    // Add new hook
    // @parameter 1 Hook Key
    // @parameter 2 Hook Callback Action
    // @parameter 3 Priority | Default 0
    PluginManagement::getInstance()->addAction($key,$callback,$priority);
    
    // Check hook
    PluginManagement::getInstance()->hasAction($key); 
    
    // Return callback execute result
    // @parameter 1 Hook Key
    // @parameter 2 Hook Send Data | array, string, number
    PluginManagement::getInstance()->doActionCallback($key,$data);
    
    // Return array 
    // @parameter 1 Hook Key
    PluginManagement::getInstance()->doActionArray($key);
    
    // die hook
    // @parameter 1 Hook Key
    PluginManagement::getInstance()->didAction($key);
```

### Helper Access
```php
    Helper::uniqidReal($length) // Default 13
```

### Sms Model
```php
    // Config builder auto create and update
    SmsBridge::autoSetup($companyId,$title,$provider,$config)

    // Send sms
    SmsBridge::send($companyID,$toPhone,$message)
```

### Text Template Builder
```php
    TemplateBridge::templateBuilder($dbModel,$id,$text)
```

### Rate Request Limit Initial
```php
    RateLimiter::init($key,$second,$limit)
```

### Short Content Management
```php
    ShortContent::addCompany($companyId,$prefix,$title,$content);
    ShortContent::setCompany($companyId,$prefix,$title,$content);
    ShortContent::getCompany($companyId,$prefix);

    ShortContent::addEmployer($employerId,$prefix,$title,$content);
    ShortContent::setEmployer($employerId,$prefix,$title,$content);
    ShortContent::getEmployer($employerId,$prefix);

    ShortContent::addCustomer($customerId,$prefix,$title,$content);
    ShortContent::setCustomer($customerId,$prefix,$title,$content);
    ShortContent::getCustomer($customerId,$prefix);
```

### Employer Permission Check
```php
    Permission::employer($employerID,array $prefix);
```

### Send Email
```php
EmailBridge::build($companyId)
    ->subject($subject) // Required
    ->content($content) // Required
    ->addReceiver($receiverEmail,$receiverHolder) // Required Multi line
    ->addCcReceiver($ccEmail,$ccHolder) // Optional Multi line
    ->addReplyReceiver($replyEmail,$replyHolder) // Optional Multi line
    ->file($fileUrl) // Optional Multi line
    ->send()
```

### Upload AWS
```php
    // Default extension list
    AwsUploadFile::PRIMARY_ALLOW_FILE_TYPES_PHOTOS
    AwsUploadFile::PRIMARY_ALLOW_FILE_TYPES_VIDEO
    AwsUploadFile::PRIMARY_ALLOW_FILE_TYPES_ALL
    
    AwsUploadFile::initial($_FILES)
        ->file($inputKey)
        ->createFileName() // Optional
        ->maxSizeMb(1) // Optional
        ->issetExtension(AwsUploadFile::PRIMARY_ALLOW_FILE_TYPES_PHOTOS) // Optional
        ->upload();
```


### Add Custom Permission
```php
    // Add to permission list at system
    PluginManagement::addPermission("Permission Title","PERMISSION_PREFIX");
```

### Add Plugin Router
```php
    // URL/api/PLUGIN_PREFIX/parameters
    PluginManagement::addApiRoute("PLUGIN_PREFIX","POST","/example",function(){ /* do some think */ });
    PluginManagement::addApiRoute("PLUGIN_PREFIX","POST","/example",[exampleController::clas,"METHOD"]);

    // URL/module/PLUGIN_PREFIX/parameters
    PluginManagement::addPluginRoute("PLUGIN_PREFIX","POST","/example",function(){ /* do some think */ });
    PluginManagement::addPluginRoute("PLUGIN_PREFIX","POST","/example",[exampleController::clas,"METHOD"]);
```


### Sample Validate Form Data
```php
    $getData = Middleware::listener(Middleware::FORM_DATA);
    
    $valid = new ValidFluent($getData->array()->result());
    
    // Sample
    $valid
    ->name("name")
    ->minSize(3,"İsim minimum %s karekter olmalıdır")
    ->required("Başlık alanı zorunludur");

    // ... more validate filters

    if(!$valid->isGroupValid())
        throw new Exception($valid->getErrors(true));

    // Optionals
    // '%S' -> İS KEY NAME
    $valid->setError("CUSTOM ERROR MESSAGE");
    $valid->name("FORM KEY");
    $valid->required("CUSTOM ERROR MESSAGE %s IS KEY NAME");
    $valid->url("CUSTOM ERROR MESSAGE %s IS KEY NAME");
    $valid->equal("Second Key","CUSTOM ERROR MESSAGE %s IS KEY NAME"); // match second key value
    $valid->oneOf("A:B:C:D","CUSTOM ERROR MESSAGE %s IS KEY NAME"); // ':' -> seperator is check in values
    $valid->text("CUSTOM ERROR MESSAGE %s IS KEY NAME"); // Is text
    $valid->alfa("CUSTOM ERROR MESSAGE %s IS KEY NAME"); // Only allows A-Z a-z 0-9 space and ( - . _ )
    $valid->maxSize("CUSTOM ERROR MESSAGE %s IS KEY NAME"); // Max length
    $valid->minSize("CUSTOM ERROR MESSAGE %s IS KEY NAME"); // Min length
    $valid->isHexColor("CUSTOM ERROR MESSAGE %s IS KEY NAME"); // check hex color code
    $valid->isArray("CUSTOM ERROR MESSAGE %s IS KEY NAME"); // check is array values
    $valid->numberFloat("CUSTOM ERROR MESSAGE %s IS KEY NAME"); // check is number float
    $valid->numberInteger("CUSTOM ERROR MESSAGE %s IS KEY NAME"); // check is number Integer
    $valid->numberMax("CUSTOM ERROR MESSAGE %s IS KEY NAME"); // check is max number
    $valid->orNull("CUSTOM ERROR MESSAGE %s IS KEY NAME"); // check and if empty and replace null value
    $valid->orNullArray("CUSTOM ERROR MESSAGE %s IS KEY NAME"); // check and if empty and replace null array items
    $valid->dateWithFormat("CUSTOM DATE FORMAT","CUSTOM ERROR MESSAGE %s IS KEY NAME");
    $valid->email("CUSTOM ERROR MESSAGE %s IS KEY NAME");
    $valid->replace("CUSTOM ERROR MESSAGE %s IS KEY NAME");
    $valid->filter("CALLABLE FUNCTION","CUSTOM ERROR MESSAGE %s IS KEY NAME");
    
    $valid->isGroupValid(); // if all value is valid then true or false
    $valid->export(); // Export all scheme
    $valid->getValue("DATA NAME"); // get value
```

# Eloquent ORM Library

### Database Model Access Samples
```php


// Short Content Model Class 
ShortContent::class

    ShortContent::addCompany($companyId,$prefix,$title,$content);
    ShortContent::setCompany($companyId,$prefix,$title,$content);
    ShortContent::getCompany($companyId,$prefix);

    ShortContent::addEmployer($employerId,$prefix,$title,$content);
    ShortContent::setEmployer($employerId,$prefix,$title,$content);
    ShortContent::getEmployer($employerId,$prefix);

    ShortContent::addCustomer($customerId,$prefix,$title,$content);
    ShortContent::setCustomer($customerId,$prefix,$title,$content);
    ShortContent::getCustomer($customerId,$prefix);


CompanyProfile::class

    // Text Data List
    CompanyProfile::DATA_TEMPLATE
    
    // Permissions
    CompanyProfile::SYSTEM_PERMISSIONS
    
    // With relationship access basic 
    CompanyOffices
    CompanyEmployers
    CompanyCustomers
    CompanyReminders
    CompanyShortContent


CompanyOffices::class
    
    // Permissions
    CompanyOffices::SYSTEM_PERMISSIONS

    // With relationship access basic
    CompanyEmployers
    CompanyProfile


CompanyEmployer::class

    // Text Data List
    CompanyEmployer::DATA_TEMPLATE

    // Permissions
    CompanyEmployer::SYSTEM_PERMISSIONS

    // With relationship access basic
    CompanyProfile
    CompanyOffices
    Reminder
    Note
    ShortContent
    FoldersAssigned
    NoteAssigned
    NoteAssigned
    ReminderAssigned


CompanyCustomer::class

    // Text Data List
    CompanyCustomer::DATA_TEMPLATE
    
    // Permissions
    CompanyCustomer::SYSTEM_PERMISSIONS

    // With relationship basic access
    Folders
    Notes
    Company
    Office
    Reminder
    ShortContent
    
    // Custom Filter
    checkCustomer($customerId)
    
    // Scopes
    corporate
    individual
    ofStatus($activeOrPassive)


Reminder:class 
    
    // Permissions
    Reminder::SYSTEM_PERMISSIONS

    // With relationship basic access
    Company
    Employer
    Customer
    Note

CustomerNote::class

    // Permissions
    CustomerNote::SYSTEM_PERMISSIONS

    // With relationship basic access
    Folders
    Company
    Customer
    Employer
    EmployersAssigment

CustomerFolder::class

    // Permissions
    CustomerFolder::SYSTEM_PERMISSIONS

    // GET MIME TYPES GROUP
    CustomerFolder::PRIMARY_ALLOW_FILE_TYPES_PHOTOS
    CustomerFolder::PRIMARY_ALLOW_FILE_TYPES_VIDEO
    CustomerFolder::PRIMARY_ALLOW_FILE_TYPES_ALL
    CustomerFolder::PRIMARY_COLOR
    CustomerFolder::PRIMARY_STATUS
    CustomerFolder::PRIMARY_SHARING
    
    // With relationship basic access
    Company
    Customer
    
    // Custom Functions
    CustomerFolder::getFolder($columnKey, $findKey,$customerId)

CompanyPluginModel::class
    
    // Scopes
    active
    
    // With relationship basic access
    Plugin
    Customer
    
PluginModel::class

    // access all db
```

