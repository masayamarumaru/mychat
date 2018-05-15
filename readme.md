# チャットby重田

## 導入手順
リポジトリをクローンorダウンロードしたら、下記の手順で有効化します(Homestead環境を想定)

### コードの配置とサイト設定

#### プロジェクトフォルダへの配置
Homesteadでのコードフォルダにソースコードをコピーします。

#### Homestead.yamlの編集
Homestead.yamlに、サイト情報を追加します
(Homestead環境の/home/vagrant/codeフォルダ以下に配置する場合)

```yaml
sites:
	- map: hogefuga.test
	  to: /home/vagrant/code/hogehoge/public
	# ↓サイト設定を追記。mapは任意名称
	- map: shigechat.test
	  to: /home/vagrant/code/ShigeChat/public
...
databases:
	- hogehoge
	# ↓データベースを追加。任意名称
	- shigechat 

```
変更後、プロビショニング(サイト設定・DBの再設定)を行います。

```shell
vagrant reload --provision
```

これで、新たにデータベースが作成されます。


#### hostsファイルの編集
ローカルのhostsファイルに、上記Homestead.yamlで`sites.map`に追加したサイトを追記します(要sudo)

mac : /private/etc/hosts  
windows : C:\Windows\System32\drivers\etc\hosts

```shell
 sudo vim /private/etc/hosts
```

hostsファイル
```
192.168.10.10 hogehoge.test
192.168.10.10 shigechat.test # 追記
```

###  プロジェクトの初期処理
#### .envの編集
ルートフォルダの`.env_example`をコピーし、`.env`にリネームしてデータベース設定を変更します。

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shigechat # 作成したデータベース名
DB_USERNAME=homestead # 環境に依存
DB_PASSWORD=secret # 環境に依存
```

#### Migration/Seederの実行
テーブル構築&初期データセットアップを行います。
プロジェクトフォルダ直下にて下記を実行
```
php artisan db:migrate
php artisan db:seed
```

### アクセス確認
http://shigechat.test

ログインフォームが表示されたら正常に配置できています。

### 初期データについて
`database/seeds`以下に初期データについて記述しています。
初期状態で以下のユーザを登録済み。

|User |Password |備考 |
|- | -| -|
|admin@example.com |mychat |管理者 |
|user1@example.com |mychat |一般 |
|user2@example.com |mychat |一般 |

