import { Component, OnInit } from '@angular/core';
import { AuthService } from '../services/auth.service';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.sass']
})
export class DashboardComponent implements OnInit {
  isLogedIn: boolean = false;

  constructor(private AuthService: AuthService) { }

  ngOnInit(): void {
    this.isLogedIn = this.AuthService.isLoggedIn.value;
    if(this.AuthService.loggedUser() == null)
    {
      let token = this.AuthService.getToken();
      if(this.isLogedIn && token) {
        this.AuthService.setUser(token);
      }
    }
  }
}
