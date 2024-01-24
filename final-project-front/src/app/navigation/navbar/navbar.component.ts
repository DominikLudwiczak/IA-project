import { Component, Input, OnInit } from '@angular/core';
import { User } from 'src/app/models/user';
import { AuthService } from 'src/app/services/auth.service';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.sass']
})
export class NavbarComponent implements OnInit{
  @Input() drawer: any;
  user: User;

  constructor(private AuthService: AuthService) {}

  ngOnInit(): void {
    this.user = this.AuthService.loggedUser();
  }

  logout() {
    this.AuthService.logout();
  }
}
