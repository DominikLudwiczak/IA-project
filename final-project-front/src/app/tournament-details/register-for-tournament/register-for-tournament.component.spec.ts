import { ComponentFixture, TestBed } from '@angular/core/testing';

import { RegisterForTournamentComponent } from './register-for-tournament.component';

describe('RegisterForTournamentComponent', () => {
  let component: RegisterForTournamentComponent;
  let fixture: ComponentFixture<RegisterForTournamentComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [RegisterForTournamentComponent]
    });
    fixture = TestBed.createComponent(RegisterForTournamentComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
