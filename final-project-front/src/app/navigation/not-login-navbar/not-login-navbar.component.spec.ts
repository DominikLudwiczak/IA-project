import { ComponentFixture, TestBed } from '@angular/core/testing';

import { NotLoginNavbarComponent } from './not-login-navbar.component';

describe('NotLoginNavbarComponent', () => {
  let component: NotLoginNavbarComponent;
  let fixture: ComponentFixture<NotLoginNavbarComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [NotLoginNavbarComponent]
    });
    fixture = TestBed.createComponent(NotLoginNavbarComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
