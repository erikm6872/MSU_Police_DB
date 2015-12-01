/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package parser;

import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Path;
//import java.nio.file.Paths;

import java.util.regex.Pattern;
import java.util.regex.Matcher;
import java.util.stream.Stream;
import java.util.List;
import java.util.ArrayList;
import java.util.Arrays;
import java.nio.file.Paths;
import java.io.File;
import java.util.Scanner;
//import java.nio.file.file

/**
 *
 * @author Matt Gannon
 */




class Pcase
{
    String caseNumber;
    
    String reportTime;
    
    String startTime;
    String endTime;
    String times;
    
    String fullDescription;
    String iDescription;
    
    String crimes;
    String[] crimesList;
    
    String location;
    String cLocation = "";
    String address;
    String campus;
    
    String disposition;
    String dDescription;
    String dArrest;
    String dReferral;
    String outcome;
    
    
}

public class Parser {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) throws Exception {
        // TODO code application logic here
        
        //if (args.length !=1)
        //{
            //System.err.println("command line error");
          //  System.exit (1);
        //}
        
        
        List<Pcase> Plist= new ArrayList<>();
        String parts;
        
        
        File dir = new File("D:/test/");
        for (File file : dir.listFiles())
        {
            
           //Scanner s = new Scanner(file); 
        //String newPath;
        //newPath = Files.toString(file);
        Path p1 = file.toPath();
       //System.out.println("here is p1 "+ p1);
        //newPath = s.toString();
        //System.out.println("here is newpath "+ newPath);
        Stream<String> lines = Files.lines(p1);
        Object[] things = lines.toArray();
        
        String sentences;
        //sentences = things[0].toString();
        // String[] tokens = sentences.split("\\s+");           

        for (int a = 0; a < things.length; a++)
        {
        sentences = things[a].toString();
        //System.out.println(sentences);
        
        List<String> items = Arrays.asList(sentences.split("\\s*,\\s*"));
       // System.out.println(items);
//String[] tokens = sentences.split("\\s+");           
       // System.out.println("ITEM SIZE "+ items.size());
        if (items.size() == 6)
        {
       for (int i = 0; i < items.size(); i++)
        {
          Pcase newPcase = new Pcase();
          newPcase.caseNumber = items.get(i++);
          newPcase.reportTime = items.get(i++);
          newPcase.times = items.get(i++);
          newPcase.fullDescription =items.get(i++);
          newPcase.location = items.get(i++);
          newPcase.disposition = items.get(i++);
          Plist.add(newPcase);
        }
        }//else 
           // System.out.println("not equal to six");
        }
        }
        
        for (Pcase pc : Plist )
        {
            //System.out.printf((pc.caseNumber) + " ");
            
            //System.out.printf((pc.reportTime)+ " ");
            

            if (pc.times.length() < 16)
            {
                pc.startTime = pc.times;
                pc.endTime = pc.times;
            }
            else 
            {
                String[] tokens = pc.times.split("\\s+");
                if (tokens.length == 1)
                {
                pc.startTime = pc.times;
                pc.endTime = pc.times;                    
                }else if(tokens.length == 4)
                {
                pc.startTime = tokens[0] + " " + tokens[1];
                pc.endTime = tokens[2] + " "+ tokens[3];
                }else 
                {
                  pc.startTime = tokens[0];
                  if ((tokens[1].length() <5) && (tokens.length == 3))
                  {
                    pc.startTime = tokens[0] + " " + tokens[1];
                    pc.endTime = tokens [2];
                  }else if ((tokens[1].length() >4) && (tokens.length == 3))
                  {
                    pc.startTime = tokens[1] + " " + tokens[2];
                    pc.endTime = tokens [0];
                  }else pc.endTime = tokens[1];
                }
            }
            //System.out.printf(pc.startTime+ "!!"+ pc.endTime + " ");
            
            String[] tokens1 = pc.fullDescription.split("-");
            
            pc.crimes = tokens1[0];
            pc.crimesList = pc.crimes.split("/");
            
            for (int b = 0; b < pc.crimesList.length; b++)
            {
                System.out.printf("(\""+pc.crimesList[b]+"\")" +",");

                //System.out.println(pc.crimesList[b]);
            }
            
            pc.iDescription = tokens1[1];
            
            
            if (pc.iDescription.contains("blue") || pc.iDescription.contains("Blue"))
            {
                pc.campus ="Blue Phone: " + pc.location;
                pc.cLocation = "On Campus";
                pc.address = "";
                
            }
            
            
                String regex = "(.)*(\\d)(.)*";      
                Pattern pattern = Pattern.compile(regex);
                Matcher matcher = pattern.matcher(pc.location);

            boolean isMatched = matcher.matches();
            if (isMatched) {
            //System.out.println("test");
                
                if (pc.cLocation.isEmpty())
                {
                    pc.address = pc.location;
                    pc.cLocation = "Off Campus";
                    pc.campus = ""; 
                    //System.out.printf("(\""+pc.address+"\")" +", ");

                }
            }else 
            {
                pc.address = "";
                pc.cLocation = "On campus";
                pc.campus = pc.location;
                                    //System.out.println(pc.campus + " ");
                    //System.out.printf("(\""+pc.campus+"\")" +", ");

                
            }
           // System.out.printf("!!" + pc.iDescription + " ");          
            //System.out.printf(();
            
            
            
            //System.out.println((pc.disposition)+ " ");
            
            if (pc.disposition.contains("open"))
            {
                pc.outcome = "open";
            }else if (pc.disposition.contains("closed"))
            {
                pc.outcome = "closed";
            }else 
            {
                pc.outcome = "pending/NA";
            }
            
            if (pc.disposition.contains("arrest"))
            {
                pc.dArrest = "y";
            }else
            {
                pc.dArrest = "n";
            }
            
            if (pc.disposition.contains("refer"))
            {
                pc.dReferral = "y";
            } else
            {
                pc.dReferral = "n";
            }
            
           // System.out.println(pc.outcome + "#" +pc.dArrest + "#" + pc.dReferral);
            


        }
         //s.close();
        
       
    }
    
}


