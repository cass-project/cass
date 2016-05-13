import {Component} from "angular2/core";
import {Router} from 'angular2/router';
import {LoadingIndicator} from "../../../util/component/LoadingIndicator/index";
import {OAuth2Component} from "../OAuth2/index";
import {AuthComponentService} from "../Auth/service";
import {AuthService} from "../../service/AuthService";

@Component({
    selector: 'cass-auth-sign-up',
    template: require('./template-stages.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        LoadingIndicator,
        OAuth2Component
    ]
})
export class SignUpComponent
{
    private SignUpTry = 0;
    private loading = false;
    private personalInfo = {
        email: '',
        password: '',
        repeat: '',
    };

    constructor(private authService: AuthService, private service: AuthComponentService, private router: Router){}

    attemptSignUp() {
        this.loading = true;

        this.authService.attemptSignUp(this.personalInfo).add(() => {
            if(!this.authService.lastError) {
                this.service.modals.closeModals();
                this.router.navigate(['/']);
                this.loading = false;
            } else if(this.SignUpTry < 5){
                setTimeout(() => {this.attemptSignUp()}, 3000);
                this.SignUpTry++;
            } else {
                console.log("Превышен интервал попыток");
                this.SignUpTry = 0;
                this.loading = false;
            }
        });
    }

    attemptSignUpNoRemember() {
        this.loading = true;

        this.authService.attemptSignUp(this.personalInfo).add(() => {
            if(!this.authService.lastError) {
                this.service.modals.closeModals();
            }

            this.loading = false;
        });
    }
}