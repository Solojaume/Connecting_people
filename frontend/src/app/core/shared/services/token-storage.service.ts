import { Injectable } from '@angular/core';
const TOKEN_KEY = 'auth-token';
const USER_KEY = 'auth-user';
const RELOAD_KEY = "reloaded";
@Injectable({
  providedIn: 'root'
})
export class TokenStorageService {
  constructor() { }
  signOut(): void {
    window.sessionStorage.clear();
  }
  public saveToken(token: string): void {
    window.sessionStorage.removeItem(TOKEN_KEY);
    window.sessionStorage.setItem(TOKEN_KEY, token);
  }
  public getToken(): string | null {
    return window.sessionStorage.getItem(TOKEN_KEY);
  }
  public saveUser(user: any): void {
    window.sessionStorage.removeItem(USER_KEY);
    window.sessionStorage.setItem(USER_KEY, JSON.stringify(user));
  }
  public getUser(): any {
    const user = window.sessionStorage.getItem(USER_KEY);
    if (user) {
      return JSON.parse(user);
    }
    return {};
  }

  public setReloadTrue(): void {
    window.sessionStorage.removeItem(RELOAD_KEY);
    window.sessionStorage.setItem(RELOAD_KEY, "true");
  }
  public setReloadFalse(): void {
    window.sessionStorage.removeItem(RELOAD_KEY);
    window.sessionStorage.setItem(RELOAD_KEY, "false");
  }

  public setCode(code:string){
    window.sessionStorage.removeItem("code");
    window.sessionStorage.setItem("code",code );
  }

  public getCode(){
    window.sessionStorage.getItem("code");
  }

  public getReload(): string | null {
    return window.sessionStorage.getItem(RELOAD_KEY);
  }
}