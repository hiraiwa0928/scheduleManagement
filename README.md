# スケジュール管理Webアプリ

このアプリは、ユーザーごとにスケジュールを管理することが出来ます。週や月ごとに表示する機能も実装しているので便利です。

# データベース設計

## データベース名　schedule_management

### memberテーブル

| Column | Type | Key |
| :---:| :---: | :---: |
| username | varchar(100) | PRI |
| password | varchar(640) |  |

### scheduleテーブル

| Column | Type | Key |
| :---:| :---: | :---: |
| id | int | PRI |
| username | varchar(100) |  |
| start | datetime |  |
| finish | datetime |  |
| contents | varchar(150) |  |
| place | varchar(150) |  |

* id：AUTO_INCREMENT