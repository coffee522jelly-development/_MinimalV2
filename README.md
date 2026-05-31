# DevMinimal - 個人開発者向け WordPress テーマ

個人開発者やエンジニア向けに設計された、ミニマルで高速な WordPress テーマです。技術ブログ、アプリ紹介、リリースノート、開発ログを一つのテーマで管理できます。

## 特徴

- **開発者向けUI**: シンプルかつクリーンなデザイン。
- **ダークモード**: 標準対応。
- **カスタムテンプレート**: 通常記事に加え、アプリ紹介、リリースノート、開発ログ専用の表示形式を搭載。
- **技術仕様**: React, TypeScript, Tailwind CSS v4, PrismJS を使用。
- **レスポンシブ**: モバイルファースト設計。

## システム要件

- WordPress 6.x 以上
- Node.js 18.x 以上
- npm 9.x 以上

## セットアップとビルド方法

テーマを正しく表示させるには、JavaScript と CSS のビルドが必要です。

### 1. 依存関係のインストール

テーマのディレクトリ（`wp-content/themes/devminimal`）で以下のコマンドを実行します：

```bash
npm install
```

### 2. テーマのビルド

開発用ビルド（ファイルの変更を監視）：
```bash
npm run start
```

本番用ビルド（最適化済みファイルの生成）：
```bash
npm run build
```

ビルドが完了すると、`build/` ディレクトリ内に `index.js` と `index.css` が生成されます。テーマはこれらを自動的に読み込みます。

## カスタマイズ

WordPress の「外観」>「カスタマイズ」から、以下の設定が可能です：

- **カラー**: メインカラー、アクセントカラーの変更。
- **SNS リンク**: GitHub, X (Twitter), Qiita, Zenn などのリンク設定。
- **コードブロック**: 背景色やフォントサイズの調整。

## ライセンス

GNU General Public License v2 or later
