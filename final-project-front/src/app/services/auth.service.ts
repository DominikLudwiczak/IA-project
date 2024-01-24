import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { BehaviorSubject } from 'rxjs';
import { User } from '../models/user';
import { AuthenticationClientService } from 'projects/api-client/src/api/authentication.service';
import { LoginRequest } from 'projects/api-client/src/model/loginRequest';


const TOKEN_KEY = 'token';
const REFRESH_TOKEN_KEY = 'refresh_token';
@Injectable({
  providedIn: 'root'
})
export class AuthService {
  public isLoggedIn: BehaviorSubject<boolean> = new BehaviorSubject<boolean>(false);
  private user: User;

  constructor(private router: Router, private authClient: AuthenticationClientService) {
    this.isUserLoggedIn();
  }

  public loginUser(login: LoginRequest, onLogin: () => void, onError: () => void) {
    this.authClient.login(login)
      .subscribe((res: any) => {
        const token = res.token;
        this.setTokens(token);
        this.isLoggedIn.next(true);
        onLogin();
      }, err => {
        onError();
      });
  }

  private isUserLoggedIn() {
    const userToken = this.getToken();
    if (userToken) {
      this.isLoggedIn.next(true);
    } else {
      this.isLoggedIn.next(false);
    }
  }

  public getToken(): string | null {
    return localStorage.getItem(TOKEN_KEY);
  }

  public getRefreshToken(): string | null {
    return localStorage.getItem(REFRESH_TOKEN_KEY);
  }

  public logout(): void {
    this.removeTokens();
    this.isLoggedIn.next(false);
    this.user = new User();
    this.router.navigate(['/login']);
  }

  public loggedUser(): User {
    return this.user;
  }

  private setTokens(userToken: string): void {
    localStorage.setItem(TOKEN_KEY, userToken);;
  }

  private removeTokens(): void {
    localStorage.removeItem(TOKEN_KEY);
  }

  public setUser(token: string) {
    this.user = new User(token);
    this.user.decodeToken();
    if (!this.user.isTokenActive()) {
      this.logout();
    }
  }
}
