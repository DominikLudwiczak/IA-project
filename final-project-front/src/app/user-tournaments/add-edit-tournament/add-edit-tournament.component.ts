import { Location } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-add-edit-tournament',
  templateUrl: './add-edit-tournament.component.html',
  styleUrls: ['./add-edit-tournament.component.sass']
})
export class AddEditTournamentComponent implements OnInit {
  loading: boolean = false;
  inEditMode: boolean = false;

  constructor(private location: Location,
              private route: ActivatedRoute) 
            {
              this.route.params.subscribe(params => {
                if(params['id'] != undefined) {
                  this.inEditMode = true;
                }
              });
            }

  ngOnInit(): void {
  }

  goBack() {
    this.location.back();
  }
}
