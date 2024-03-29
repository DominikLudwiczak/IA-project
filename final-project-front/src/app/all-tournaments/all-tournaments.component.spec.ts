import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AllTournamentsComponent } from './all-tournaments.component';

describe('AllTournamentsComponent', () => {
  let component: AllTournamentsComponent;
  let fixture: ComponentFixture<AllTournamentsComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [AllTournamentsComponent]
    });
    fixture = TestBed.createComponent(AllTournamentsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
