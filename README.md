erDiagram
  users {
    int id PK
    string name
		string email UK 
		string register_token "仮登録時のトークン"
    timestamp register_token_sent_at "トークンの有効期限決めるために使用"
    timestamp register_token_verified_at "本登録完了したら更新"
		string password 
    timestamp created_at
		timestamp update_at
  }