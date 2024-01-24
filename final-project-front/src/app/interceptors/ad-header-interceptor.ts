import { HttpInterceptor, HttpRequest, HttpHandler, HttpEvent, HttpErrorResponse } from "@angular/common/http";
import { BehaviorSubject, Observable, catchError, filter, switchMap, take, throwError } from "rxjs";
import { AuthService } from "../services/auth.service";

export class AddHeaderInterceptor implements HttpInterceptor {
  private isRefreshing = false;
  private refreshTokenSubject: BehaviorSubject<any> = new BehaviorSubject<any>(
    null
  );

  public constructor(private loginService: AuthService) {}

  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    req = req.clone({ headers: req.headers.append('Content-Type', 'application/json') });
    var token = this.loginService.getToken();
    if (token) {
      req = req.clone({
        headers: req.headers.append('Content-Type', 'application/json')
          .append('Authorization', `Bearer ${token}`)
      });
    }

    return next.handle(req);
  }
}