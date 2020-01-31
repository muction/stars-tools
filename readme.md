### 系统工具类

##### 一、 Translate 翻译类

> BaiDuTranslate 百度翻译接口

**快速使用**

``` 
  use Stars\Tools\Foundation\Translate;
  use Stars\Tools\Foundation\Lib\Translate\BaiDuTranslate;

  $translate = new Translate(
       new BaiDuTranslate( 'AppId' , 'Scecet'  )
   ); 
  $translate->setContent("要翻译的内容);
  $result = $translate->result();   
```

**返回结果**

``` 
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


