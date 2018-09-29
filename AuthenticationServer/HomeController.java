package Auth;

import org.springframework.boot.autoconfigure.amqp.RabbitProperties;
import org.springframework.util.comparator.BooleanComparator;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;

import java.sql.*;

@RestController
public class HomeController {

    @RequestMapping(value = "/login", method = RequestMethod.POST)
    public String login(@RequestParam(value = "eml") String email, @RequestParam(value = "passwd") String password) {
        String[] RITusr = email.split("@rit.edu");
        if(RITusr[0].length() > 10){
            return "Invalid Username";
        }
        try{
            Class.forName("com.mysql.jdbc.Driver");
            Connection con= DriverManager.getConnection(
                    "jdbc:mysql://mysql-db:3306/skitter","root","supersecurepass");
            PreparedStatement stmnt = con.prepareStatement("select * from users where rit_user=?");
            stmnt.setString(1, RITusr[0]);
            ResultSet result = stmnt.executeQuery();
            if(result.isBeforeFirst()) {
                Boolean signin = LDAPLogin.doLogin(RITusr[0], password);
                  if(signin) {
                      String session = Registration.createSession(RITusr[0]);
                      con.close();
                      return "success:"+session;
                  }else {
                      con.close();
                      return "register";
                  }
            }else
                return "login failed";
        }catch(Exception e) {
            System.out.println(e);
            return "error";
        }
    }

    @RequestMapping(value = "/register", method = RequestMethod.POST)
    public String register(@RequestParam(value = "usr") String username, @RequestParam(value = "display") String display,
                           @RequestParam(value = "eml") String email){
        if(username.length() > 10){
            return "Username invalid";
        }else if(display.length() > 30){
            return "DisplayName invalid";
        }else if(email.length() > 100){
            return "Invalid email";
        }
        String toReturn = "";
        try{
            Class.forName("com.mysql.jdbc.Driver");
            Connection con= DriverManager.getConnection(
                    "jdbc:mysql://mysql-db:3306/skitter","root","supersecurepass");
            //Statement stmnt = con.createStatement();
            PreparedStatement stmnt = con.prepareStatement("select * from users where rit_user=?");
            stmnt.setString(1, username);
            ResultSet result = stmnt.executeQuery();
            if(result.isBeforeFirst()) {
                toReturn = "registration failed";
            }else {
                PreparedStatement register = con.prepareStatement("insert into users values(?,?,?,NULL)");
                register.setString(1, username);
                register.setString(2, email);
                register.setString(3, display);
                register.executeUpdate();
                toReturn = "created";
            }
            con.close();
        }catch(Exception e) {
            System.out.println(e);
            toReturn = "error";
        }

        return toReturn;
    }
    @RequestMapping(value = "/isAuthenticated", method = RequestMethod.POST)
    public String isAuthenticated(@RequestParam(value = "id") String session_id){
        boolean authd = Registration.verifySession(session_id);
        if(authd) {
            return "valid";
        }
        return "invalid";
    }
}