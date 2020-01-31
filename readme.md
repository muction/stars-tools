### 系统工具类

##### 一、 Translate 翻译类

> BaiDuTranslate 百度翻译接口

**快速使用**

```php  
  use Stars\Tools\Foundation\Translate;
  use Stars\Tools\Lib\Translate\BaiDuTranslate;

  $translate = new Translate(
       new BaiDuTranslate( 'AppId' , 'Scecet'  )
   ); 
  $translate->setContent("要翻译的内容);
  $result = $translate->result();

```

**返回结果**

```php  
  [
    ['src'=> '原文' ,'dst'=>'译文']
  ] 

```


##### 二、 PATCH补丁包管理

> 1、制作补丁包   
> 支持通过Git Commit 记录和指定文件自动打包相应文件，制作补丁包文件。

```
  1.1 Git方式
    Stars\Tools\Foundatio\PatchMake::makeGitPatch(); 
```

```
  1.2 File方式 
    Stars\Tools\Foundatio\PatchMake::makeFilePatch(); 
```


> 2、应用补丁包

``` 
  Stars\Tools\Foundation\PatchApply::apply();
```


##### 三、 Peace 系统搜索器

```php
   use Stars\Tools\Foundation\SearchPeace;

   $search = new SearchPeace();
   $search->setKeyWord( "你好" );
   $search->addSearchMenuBindConfig( 12 , [ 'title','summary'] , ['id','title' ,'summary' ,'bind_id'] );
   $search->addSearchMenuBindConfig( 13 , [ 'title','summary'] , ['id','title' ,'summary' ,'bind_id'] );
   $datas = $search->paginate(1) ;
```
