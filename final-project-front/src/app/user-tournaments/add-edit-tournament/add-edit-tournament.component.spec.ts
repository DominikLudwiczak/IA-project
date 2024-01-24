import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AddEditTournamentComponent } from './add-edit-tournament.component';

describe('AddEditTournamentComponent', () => {
  let component: AddEditTournamentComponent;
  let fixture: ComponentFixture<AddEditTournamentComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [AddEditTournamentComponent]
    });
    fixture = TestBed.createComponent(AddEditTournamentComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
