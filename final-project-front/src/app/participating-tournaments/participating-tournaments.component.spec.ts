import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ParticipatingTournamentsComponent } from './participating-tournaments.component';

describe('ParticipatingTournamentsComponent', () => {
  let component: ParticipatingTournamentsComponent;
  let fixture: ComponentFixture<ParticipatingTournamentsComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [ParticipatingTournamentsComponent]
    });
    fixture = TestBed.createComponent(ParticipatingTournamentsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
